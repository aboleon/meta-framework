<?php

namespace MetaFramework\Mediaclass\Controllers;

use MetaFramework\Mediaclass\Accessors\Cropable;
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
    protected object $model;
    protected array $dimensions;
    protected array $urls = [];

    protected string $mime_type;
    protected string $filename;
    protected object $uploadedFile;


    private Mediaclass $media;
    private ?string $temp;
    private ?int $model_id;

    public function __construct()
    {
        $this->model_id = (int)request('model_id') ?: null;
        $this->temp = request('mediaclass_temp_id') ?: null;
    }

    public function setModel(string $model): static
    {

        try {
            $this->model = (new ReflectionClass($model))->newInstance();
            if ($this->model_id) {
                $this->model = $this->model->find($this->model_id);
            }
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

        $this->response['has_positions'] = (bool)request('positions');

        if (str_contains($this->uploadedFile->getMimeType(), 'svg')) {
            $this->response['filename'] = $this->filename . '.svg';

            $file = $this->model->accessKey() . '/' . $this->response['filename'];
            $this->media = $this->store();

            $img = Storage::disk('media')->url($file . '?' . time());
            $this->urls['sm'] = $img;
            $this->urls['xl'] = $img;

            $this->uploadedFile->move(Storage::disk('media')->path($this->model->accessKey()), $this->response['filename']);

            $this->mediaResponse();

            return $this;
        }

        if (strstr($this->uploadedFile->getMimeType(), '/', true) != 'image') {
            $this->responseAbort(trans('mediaclass.errors.mustBeImage'));
            return $this;
        }

        return $this->processImage();
    }


    private function processImage(): static
    {
        $this->dimensions = config('mediaclass.dimensions');
        $this->image = Image::make($this->uploadedFile);
        $this->urls = [];

        $this->mime_type = (str_replace('image/', '', $this->image->mime()) == 'png' ? 'png' : 'jpg');
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
        $this->media = $this->store();
        $this->media->model = $this->model;

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

    private function mediaResponse(): self
    {
        $this->responseElement('urls', $this->urls);
        $this->responseElement('uploaded', $this->media);
        $cropable = new Cropable($this->media);
        $this->responseElement('sizes', $cropable->printSizes());
        $this->responseElement('cropable_link', $cropable->link());
        $this->responseElement('temp', $this->temp);
        return $this;
    }

}
