<?php

namespace Aboleon\MetaFramework\Mediaclass\Controllers;

use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Aboleon\MetaFramework\Mediaclass\Config;
use Aboleon\MetaFramework\Mediaclass\Cropable;
use Aboleon\MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use Aboleon\MetaFramework\Mediaclass\Mediaclass;
use Aboleon\MetaFramework\Mediaclass\Models\Media;
use Aboleon\MetaFramework\Mediaclass\Path;
use Aboleon\MetaFramework\Traits\Responses;
use ReflectionClass;
use Throwable;

class FileUploadImages
{
    use Responses;

    protected object $image;
    protected MediaclassInterface $model;
    protected array $dimensions;
    protected array $urls = [];

    protected string $mime_type;
    protected string $filename;
    protected object $uploadedFile;


    private Media $media;
    private ?string $temp;
    private ?int $model_id;
    private string $folder_name = '';

    private Filesystem $disk;

    public function __construct()
    {
        $this->model_id = (int)request('model_id') ?: null;
        $this->temp = request('mediaclass_temp_id') ?: null;

        $this->response['filetype'] = 'image';

        $this->disk = Config::getDisk();
    }

    public function setModel(?string $model = null): static
    {
        if (!$model) {
            $this->responseError(__('mediaclass.missing_model'));
            return $this;
        }

        try {
            $this->model = (new ReflectionClass($model))->newInstance();

            if ($this->model_id) {
                $this->model = $this->model->find($this->model_id);
            }

            $this->folder_name = Path::mediaFolderName($this->model);


        } catch (Throwable $e) {
            $this->responseException($e, "Unknown " . $model . " class in " . static::class);
        }

        return $this;
    }

    /**
     * Deletes a Mediaclass record and all its files
     * Deletes the relative directory if it is empty
     * @return $this
     */
    public function delete(): static
    {
        try {
            $media = Media::query()->find(request('id'));
            $path = Path::mediaFolderName($media->model);
            File::delete(
                File::glob(
                    $this->disk->path($path . DIRECTORY_SEPARATOR . '*' . $media->filename . '*')
                )
            );

            if (count($this->disk->files($path)) === 0) {
                $this->disk->deleteDirectory($path);
            }

            $media->delete();
        } catch (Throwable $e) {
            $this->responseException($e);
            report($e);
        }
        return $this;
    }

    public function upload(): static
    {
        $this->filename = Str::random(6);
        $this->uploadedFile = request()->file('files')[0];

        if ($this->hasErrors()) {
            return $this;
        }

        // documents
        if (strstr($this->uploadedFile->getMimeType(), '/', true) != 'image') {
            // Move non-image files
            // TODO: controls
            return $this->uploadFiles();
        }

        $this->response['has_positions'] = (bool)request('positions');

        // svg
        if (str_contains($this->uploadedFile->getMimeType(), 'svg')) {
            return $this->uploadSvg();
        }

        if (strstr($this->uploadedFile->getMimeType(), '/', true) != 'image') {
            $this->responseAbort(trans('mediaclass.errors.mustBeImage'));
            return $this;
        }

        return $this->processImage();
    }

    private function uploadFiles(): static
    {
        $this->response['filetype'] = 'file';
        $this->response['filename'] = $this->filename . '.' . $this->uploadedFile->guessExtension();
        $this->response['link'] = $this->disk->url($this->response['filename'] . '?' . time());;
        $this->response['fileicon'] = asset('vendor/aboleon/mediaclass/images/files/' . $this->uploadedFile->guessExtension() . '.png');
        $this->response['preview'] = $this->response['fileicon'];

        try {
            $this->media = $this->store();
        } catch (Throwable $e) {
            $this->responseException($e);
        }

        $this->uploadedFile->move($this->disk->path($this->folder_name), $this->response['filename']);

        $this->mediaResponse();
        return $this;
    }

    private function uploadSvg(): static
    {
        $this->response['filename'] = $this->filename . '.svg';
        $file = $this->folder_name . '/' . $this->response['filename'];
        $img = $this->disk->url($file . '?' . time());
        $this->response['fileicon'] = asset('vendor/aboleon/mediaclass/images/files/svg.png');

        try {
            $this->media = $this->store();
        } catch (Throwable $e) {
            $this->responseException($e);
        }

        $this->uploadedFile->move($this->disk->path($this->folder_name), $this->response['filename']);

        $this->responseElement('link', $this->disk->url($file));
        $this->responseElement('preview', $img);

        $this->mediaResponse();

        return $this;
    }


    private function processImage(): static
    {
        $this->dimensions = config('mediaclass.dimensions');
        $this->image = Image::make($this->uploadedFile);
        $this->urls = [];

        $this->mime_type = (str_replace('image/', '', $this->image->mime()) == 'png' ? 'png' : 'jpg');
        $this->response['fileicon'] = asset('vendor/aboleon/mediaclass/images/files/jpg.png');
        $ratio = ($this->image->width() / $this->image->height()) > 1 ? 'h' : 'v';
        $this->response['ratio'] = $ratio;


        foreach ($this->dimensions as $key => $dimensions) {

            $file = $this->folder_name . '/' . $dimensions['width'] . '_' . $this->filename . '.' . $this->mime_type;

            $this->disk->put($file,
                $this->image->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->stream($this->mime_type, 75));

            if (in_array($key, ['xl', 'sm'])) {
                $this->urls[$key] = $this->disk->url($file . '?' . time());
            }
        }

        $this->responseElement('link', $this->urls['xl'] ?? Config::defaultImgUrl());
        $this->responseElement('preview', $this->urls['sm'] ?? Config::defaultImgUrl());
        $this->responseElement('urls', $this->urls);

        try {
            $this->media = $this->store();

            $this->media->model = $this->model;

            $cropable = new Cropable($this->media);

            $cropable->setCropableFromComponent((string)request('cropable'));
            $this->responseElement('sizes', $cropable->printSizes());
            $this->responseElement('cropable_link', $cropable->link());

            $this->mediaResponse();

        } catch (Throwable $e) {
            $this->responseException($e);
        }


        return $this;
    }

    /**
     * @throws \Exception
     */
    private function store(): Media
    {
        if (config()->has('app.cacheables') & in_array($this->model->type, (array)config('app.cacheables'))) {
            cache()->forget($this->model->type);
        }

        $morphable = Relation::morphMap() ? array_key_first(array_filter(Relation::morphMap(), fn($item) => $item == get_class($this->model))) : get_class($this->model);
        $path = Path::mediaFolderName($this->model);

        if (!$morphable) {
            File::delete(File::glob($this->disk->path($path . DIRECTORY_SEPARATOR . '*' . $this->filename . '*')));
            throw new Exception("Invalid Media morphable");
        }

        return Media::query()->create([
            'model_type' => $morphable,
            'model_id' => $this->model_id,
            'group' => request('group') ?: Config::defaultGroup(),
            'subgroup' => request('subgroup') ?: null,
            'description' => request('description'),
            'position' => request('position') ?: 'left',
            'mime' => $this->uploadedFile->getMimeType(),
            'original_filename' => $this->uploadedFile->getClientOriginalName(),
            'filename' => $this->filename,
            'temp' => $this->temp
        ]);
    }

    private function mediaResponse(): static
    {
        $this->responseElement('uploaded', $this->media);
        $this->responseElement('temp', $this->temp);
        $this->responseElement('count_files', request('count_files'));
        return $this;
    }

}
