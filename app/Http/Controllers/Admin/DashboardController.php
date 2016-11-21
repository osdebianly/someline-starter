<?php

namespace Someline\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Someline\Base\Http\Controllers\Controller;
use Someline\Http\Requests;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.index');
    }
}
