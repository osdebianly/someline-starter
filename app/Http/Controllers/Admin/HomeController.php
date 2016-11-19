<?php

namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Someline\Http\Controllers\BaseController;
use Someline\Http\Requests;

class HomeController extends BaseController
{

    public function index()
    {
        return view('admin.home.index');
    }

}
