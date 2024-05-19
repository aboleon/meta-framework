<?php

namespace Aboleon\MetaFramework\Mediaclass\Controllers;



use Aboleon\MetaFramework\Accessors\Users;
use Aboleon\MetaFramework\Controllers\Controller;
use Aboleon\MetaFramework\Traits\Ajax;

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
