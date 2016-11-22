@extends('admin.angulr.layout.frame')

@section('content')

    <div class="app-content-body ">


        <div class="bg-light lter b-b wrapper-md">
            <h1 class="m-n font-thin h3">角色管理</h1>
        </div>
        <div class="wrapper-md">
            <div class="panel panel-default">
                <div class="panel-heading">
                    角色列表
                </div>
                <div class="table-responsive">
                </div>

            </div>
            <role-list></role-list>
        </div>


    </div>

@endsection
