<?php

namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Someline\Base\Http\Controllers\Controller;
use Someline\Http\Requests;

class HomeController extends Controller
{

    public function index()
    {
        return view('admin.home.index');
    }

}
