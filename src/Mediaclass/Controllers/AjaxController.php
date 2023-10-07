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

        ini_set('memory_limit', config('mediaclass.memory_limit','256M'));
        ini_set('post_max_size', config('mediaclass.post_max_size','64M'));
        ini_set('upload_max_filesize', config('mediaclass.upload_max_filesize','10M'));

        $this->uploader = new FileUploadImages;
    }

    public function upload(): array
    {
        return $this->uploader->setModel(request('model'))->upload()->fetchResponse();
    }

    public function crop(): array
    {
        return Cropper::crop();
    }

    public function delete(): array
    {
        return $this->uploader->delete()->fetchResponse();
    }


}
