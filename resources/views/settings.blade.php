@extends('layouts.app')

@section('title', __('settings.Settings'))

@section('content')
<div class="container">

    @if(!Auth::check())
        <h3 class="text-center">@lang('settings.Settings')</h3>

        <div class="alert alert-warning" role="alert">
            @lang('settings.ToChangeSettings') <a href="{{ route('login') }}" class="alert-link">@lang('settings.Authorize')</a> @lang('settings.Or') <a href="{{ route('register') }}" class="alert-link">@lang('settings.Register')</a>.
        </div>
    @elseif(!Auth::user()->hasVerifiedEmail())
        <h3 class="text-center">@lang('settings.Settings')</h3>

        <div class="alert alert-warning" role="alert">
            @lang('settings.ToChangeSettings') @lang('settings.ConfirmEmail', ['email' => Auth::user()->email])
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Session::has('saveStatus'))
                    @if(Session::get('saveStatus') == 'Success')
                        <div class="alert alert-success" role="alert">
                            @lang('settings.SuccessSave')
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            @lang('settings.ErrorSave')
                        </div>
                    @endif
                @endif

                <div class="card">
                    <div class="card-header">@lang('settings.Settings')</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="pomidor_duration" class="col-md-6 col-form-label text-md-right">@lang('settings.PomidorDurationInMin')</label>

                                <div class="col-md-4">
                                    <input id="pomidor_duration" type="number" min="1" max="360" class="form-control @error('pomidor_duration') is-invalid @enderror" name="pomidor_duration" value="{{ old('pomidor_duration', $settings['pomidor_duration']) }}" required>

                                    @error('pomidor_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <span>{{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="short_rest_duration" class="col-md-6 col-form-label text-md-right">@lang('settings.ShortRestDuration')</label>

                                <div class="col-md-4">
                                    <input id="short_rest_duration" type="number" min="1" max="360" class="form-control @error('short_rest_duration') is-invalid @enderror" name="short_rest_duration" value="{{ old('short_rest_duration', $settings['short_rest_duration']) }}" required>

                                    @error('short_rest_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <span>{{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="long_rest_duration" class="col-md-6 col-form-label text-md-right">@lang('settings.LongRestDuration')</label>

                                <div class="col-md-4">
                                    <input id="long_rest_duration" type="number" min="1" max="360" class="form-control @error('long_rest_duration') is-invalid @enderror" name="long_rest_duration" value="{{ old('long_rest_duration', $settings['long_rest_duration']) }}" required>

                                    @error('long_rest_duration')
                                    <span class="invalid-feedback" role="alert">
                                        <span>{{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="long_rest_via_count_pomidors" class="col-md-6 col-form-label text-md-right">@lang('settings.LongRestViaCountPomidors')</label>

                                <div class="col-md-4">
                                    <input id="long_rest_via_count_pomidors" type="number" min="1" max="10" class="form-control @error('long_rest_via_count_pomidors') is-invalid @enderror" name="long_rest_via_count_pomidors" value="{{ old('long_rest_via_count_pomidors', $settings['long_rest_via_count_pomidors']) }}" required>

                                    @error('long_rest_via_count_pomidors')
                                    <span class="invalid-feedback" role="alert">
                                        <span>{{ $message }}</span>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 offset-md-6">
                                    <div class="form-check">
                                        <input type="hidden" name="need_sound_timer_finished" value="0" />
                                        <input class="form-check-input @error('need_sound_timer_finished') is-invalid @enderror" type="checkbox" name="need_sound_timer_finished" id="need_sound_timer_finished" value="1" {{ old('need_sound_timer_finished', $settings['need_sound_timer_finished']) ? 'checked' : '' }}>

                                        <label class="form-check-label" for="need_sound_timer_finished">
                                            @lang('settings.NeedSoundTimerFinished')
                                        </label>

                                        @error('need_sound_timer_finished')
                                        <span class="invalid-feedback" role="alert">
                                            <span>{{ $message }}</span>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('settings.Save')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
