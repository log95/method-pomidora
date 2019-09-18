@extends('layouts.app')

@section('title', __('500.ServerError'))

@section('content')
    <div class="container">
        <div class="alert alert-warning" role="alert">
            @lang('500.ServerError')
        </div>
    </div>
@endsection
