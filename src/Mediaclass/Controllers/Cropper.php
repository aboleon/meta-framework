<?php

namespace MetaFramework\Mediaclass\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use MetaFramework\Mediaclass\Cropable;
use MetaFramework\Mediaclass\Models\Media;
use MetaFramework\Traits\Responses;
use Throwable;

class Cropper
{
    use Responses;

    public static function crop(): array
    {
        $cropper = new Cropper;

        try {
            $media = Media::query()->findOrFail(request('object_id'));
            $file = $media->file('xl');
            $image = Image::make($file);

            $filename = $media->bindedModel()->access_key . '/cropped_' . $media->filename . '.' . $media->extension();

            Storage::disk('media')->put($filename,
                $image->crop(
                    (int)request('wimage'),
                    (int)request('himage'),
                    (int)request('x1image'),
                    (int)request('y1image')
                )->resize(
                    request('wiimage'),
                    request('heimage'), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->stream($media->mime, 80));


            $cropable = new Cropable($media);
            $img = Storage::disk('media')->url($filename);
            $cropper->responseElement('sizes', $cropable->printSizes());
            $cropper->responseElement('cropable_link', $cropable->link());
            $cropper->responseElement('uploaded', $media);
            $cropper->responseElement('callback', 'cropped');
            $cropper->responseElement('urls', ['xl' => $img, 'sm' => $img]);

        } catch (Throwable $e) {
            $cropper->responseException($e);

        } finally {
            return $cropper->fetchResponse();
        }


    }
}
