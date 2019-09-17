@extends('layouts.app')

@section('title', __('email_verification.VerifyEmailAddress'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('email_verification.VerifyEmailAddress')</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('email_verification.NewVerificationLinkSended')
                        </div>
                    @endif
                    @lang('email_verification.CheckEmailForVerificationLink')
                    @lang('email_verification.NotReceiveEmail'),
                    <a href="{{ route('verification.resend') }}">
                        @lang('email_verification.ClickToResend')
                    </a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
