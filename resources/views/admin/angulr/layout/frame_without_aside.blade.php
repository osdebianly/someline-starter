@extends('admin.angulr.layout.master')

@section('div.app.class', 'app-header-fixed app-aside-fixed app-aside-hidden')

@section('app')

    @include('admin.angulr.layout.parts.header')

    @include('admin.angulr.layout.parts.content')

    @include('admin.angulr.layout.parts.footer')

@endsection