@extends('layouts.app')

@section('title', __('404.PageNotFound'))

@section('content')
    <div class="container">
        <div class="alert alert-warning" role="alert">
            @lang('404.PageNotFound')
        </div>
    </div>
@endsection
