@extends('layouts.app')

@section('content')
    @if(session()->has('authProviderError'))
        <div class="container">
            <div>
                <div class="alert alert-warning" role="alert">
                    @lang('app.authProviderError')
                </div>
            </div>
        </div>
    @endif
    <div id="app" class="container">
        <div class="d-flex justify-content-center">
            <div class="spinner-border text-secondary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    @push('head_css')
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @endpush

    @push('body_scripts')
        <script>
            transMessages['TASK_INVALID_DATA_TITLE'] = '@lang('app.TASK_INVALID_DATA_TITLE')';
            transMessages['TASK_INVALID_DATA_DESC'] = '@lang('app.TASK_INVALID_DATA_DESC')';
            transMessages['TASK_TITLE_PLACEHOLDER'] = '@lang('app.TASK_TITLE_PLACEHOLDER')';
            transMessages['TASK_DESCRIPTION_PLACEHOLDER'] = '@lang('app.TASK_DESCRIPTION_PLACEHOLDER')';
            transMessages['ADD_TASK_PLACEHOLDER'] = '@lang('app.ADD_TASK_PLACEHOLDER')';
            transMessages['ACTIVE_TASKS'] = '@lang('app.ACTIVE_TASKS')';
            transMessages['COMPLETED_TASKS_TODAY'] = '@lang('app.COMPLETED_TASKS_TODAY')';
            transMessages['COMPLETE_TASK'] = '@lang('app.COMPLETE_TASK')';
            transMessages['EDIT_TASK'] = '@lang('app.EDIT_TASK')';
            transMessages['REMOVE_TASK'] = '@lang('app.REMOVE_TASK')';
            transMessages['APPLY'] = '@lang('app.APPLY')';
            transMessages['CANCEL'] = '@lang('app.CANCEL')';
            transMessages['START_TIMER'] = '@lang('app.START_TIMER')';
            transMessages['PAUSE_TIMER'] = '@lang('app.PAUSE_TIMER')';
            transMessages['STOP_TIMER'] = '@lang('app.STOP_TIMER')';
            transMessages['FINISH_TIMER'] = '@lang('app.FINISH_TIMER')';
            transMessages['POMIDOR_NUMBER'] = '@lang('app.POMIDOR_NUMBER')';
            transMessages['REST'] = '@lang('app.REST')';
            transMessages['LONG_REST'] = '@lang('app.LONG_REST')';
            transMessages['POMIDOR_QUOTE'] = '@lang('app.POMIDOR_QUOTE')';
        </script>
        <script src="{{ mix('js/app.js') }}"></script>
    @endpush
@endsection
