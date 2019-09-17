@extends('layouts.app')

@section('title', __('success_verified.SuccessVerified'))

@section('content')
    <div class="container">
        <div class="alert alert-success" role="alert">
            @lang('success_verified.SuccessVerified') <a href="/" class="alert-link">@lang('success_verified.GoToMainPage')</a>.
        </div>
    </div>
@endsection
