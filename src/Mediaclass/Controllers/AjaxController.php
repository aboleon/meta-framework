<?php

namespace MetaFramework\Mediaclass\Controllers;



use MetaFramework\Accessors\Users;
use MetaFramework\Controllers\Controller;
use MetaFramework\Traits\Ajax;

class AjaxController extends Controller
{
    use Ajax;

    private FileUploadImages $uploader;

    public function __construct()
    {
        $users = (new Users());
        $this->uploader = new FileUploadImages;
    }

    public function upload(): array
    {
        return $this->uploader
            ->setModel((string)request('model'))
            ->upload()
            ->fetchResponse();
    }

    public function crop(): array
    {
        return Cropper::crop();
    }

    public function delete(): array
    {
        return $this->uploader
            ->delete()
            ->fetchResponse();
    }


}
