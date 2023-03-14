<?php

namespace MetaFramework\Mediaclass\Controllers;

use MetaFramework\Mediaclass\Accessors\Cropable;
use MetaFramework\Mediaclass\Accessors\Path;
use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use MetaFramework\Mediaclass\Models\Mediaclass;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use MetaFramework\Traits\Responses;
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


    private Mediaclass $media;
    private ?string $temp;
    private ?int $model_id;
    private string $folder_name = '';

    public function __construct()
    {
        $this->model_id = (int)request('model_id') ?: null;
        $this->temp = request('mediaclass_temp_id') ?: null;

        $this->response['filetype'] = 'image';
    }

    public function setModel(string $model): static
    {
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

    public function delete(): static
    {
        try {
            $this->media = Mediaclass::query()->findOrFail(request('id'));
            File::delete(File::glob(Storage::disk('media')->path((string)$this->media->model->accessKey()) . DIRECTORY_SEPARATOR . '*' . $this->media->filename . '*'));
            $this->media->delete();
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
        $this->response['link'] = Storage::disk('media')->url($this->response['filename'] . '?' . time());;
        $this->response['fileicon'] = asset('vendor/metaframework/mediaclass/images/files/'.$this->uploadedFile->guessExtension().'.png');
        $this->response['preview'] = $this->response['fileicon'];

        try {
            $this->media = $this->store();
        } catch (Throwable $e) {
            $this->responseException($e);
        }

        $this->uploadedFile->move(Storage::disk('media')->path($this->folder_name), $this->response['filename']);

        $this->mediaResponse();
        return $this;
    }

    private function uploadSvg(): static
    {
        $this->response['filename'] = $this->filename . '.svg';
        $file = $this->folder_name . '/' . $this->response['filename'];
        $img = Storage::disk('media')->url($file . '?' . time());
        $this->response['fileicon'] = asset('vendor/metaframework/mediaclass/images/files/svg.png');

        try {
            $this->media = $this->store();
        } catch (Throwable $e) {
            $this->responseException($e);
        }

        $this->uploadedFile->move(Storage::disk('media')->path($this->folder_name), $this->response['filename']);

        $this->responseElement('link', Storage::disk('media')->url($file));
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
        $this->response['fileicon'] = asset('vendor/metaframework/mediaclass/images/files/jpg.png');
        $ratio = ($this->image->width() / $this->image->height()) > 1 ? 'h' : 'v';
        $this->response['ratio'] = $ratio;


        foreach ($this->dimensions as $key => $dimensions) {

            $file = $this->model->accessKey() . '/' . $dimensions['width'] . '_' . $this->filename . '.' . $this->mime_type;

            Storage::disk('media')->put($file,
                $this->image->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->stream($this->mime_type, 75));

            if (in_array($key, ['xl', 'sm'])) {
                $this->urls[$key] = Storage::disk('media')->url($file . '?' . time());
            }
        }

        $this->responseElement('link', $this->urls['xl'] ?? \MetaFramework\Mediaclass\Accessors\Mediaclass::defaultImgUrl());
        $this->responseElement('preview', $this->urls['sm'] ?? \MetaFramework\Mediaclass\Accessors\Mediaclass::defaultImgUrl());
        $this->responseElement('urls', $this->urls);

        try {
            $this->media = $this->store();
        } catch (Throwable $e) {
            $this->responseException($e);
        }

        $this->media->model = $this->model;
        $cropable = new Cropable($this->media);
        $this->responseElement('sizes', $cropable->printSizes());
        $this->responseElement('cropable_link', $cropable->link());

        $this->mediaResponse();

        return $this;
    }

    /**
     * @throws \Exception
     */
    private function store(): Mediaclass
    {
        if (in_array($this->model->type, config('app.cacheables'))) {
            cache()->forget($this->model->type);
        }

        $morphable = Relation::morphMap() ? array_key_first(array_filter(Relation::morphMap(), fn($item) => $item == get_class($this->model))) : get_class($this->model);
        if (!$morphable) {
            File::delete(File::glob(Storage::disk('media')->path((string)$this->model->accessKey()) . DIRECTORY_SEPARATOR . '*' . $this->filename . '*'));
            throw new Exception("Invalid Mediaclass morphable");
        }

        return Mediaclass::query()->create([
            'model_type' => $morphable,
            'model_id' => $this->model_id,
            'group' => request('group') ?: 'media',
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
        return $this;
    }

}
