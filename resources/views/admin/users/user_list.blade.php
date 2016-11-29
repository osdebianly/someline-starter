@extends('admin.angulr.layout.frame')

@section('content')

    <div class="app-content-body ">
        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">用户管理</h1>
        </div>
        <div class="wrapper-md">
            <user-list></user-list>
        </div>
    </div>

@endsection