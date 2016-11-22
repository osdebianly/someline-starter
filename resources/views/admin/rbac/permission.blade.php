@extends('admin.angulr.layout.frame')

@section('content')

    <div class="app-content-body ">


        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">权限管理</h1>
        </div>
        <div class="wrapper-md">
            <div class="panel panel-default">
                <div class="panel-heading">
                    权限列表
                </div>
                <div class="table-responsive">
                </div>

            </div>
            <permission-list></permission-list>
        </div>


    </div>

@endsection
