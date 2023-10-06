<?php

namespace App\Http\Controllers;


use MetaFramework\Traits\Responses;
class TestableController extends Controller
{
    use Responses;

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function index()
    {

    }


}

