@extends('layouts.app')

@section('title', __('history.PageTitle'))

@section('content')
    <div class="container">

        <h3 class="text-center">@lang('history.PageTitle')</h3>

        @if(!Auth::check())
            <div>
                <div class="alert alert-warning" role="alert">
                    @lang('history.ToShowCompletedTasks') <a href="{{ route('login') }}" class="alert-link">@lang('history.Authorize')</a>.
                </div>
            </div>
        @elseif(!Auth::user()->hasVerifiedEmail())
            <div>
                <div class="alert alert-warning" role="alert">
                    @lang('history.ToShowCompletedTasks') @lang('history.ConfirmEmail', ['email' => Auth::user()->email])
                </div>
            </div>
        @else
            <div class="mb-5">
                <span>@lang('history.FilterDate'):&nbsp;&nbsp;</span>
                <span class="dropdown">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownFilterDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @lang('history.dateFilter.' . $activeFilter['date'])
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownFilterDate" id="filterDateVariants">
                        @foreach($filters['date'] as $filterCode)
                            @if($filterCode === 'for_all_time')
                                <div class="dropdown-divider"></div>
                            @endif
                            <a
                                class="dropdown-item @if($filterCode == $activeFilter['date']) active @endif"
                                href="{{ route('history', ['filter-date' => $filterCode]) }}"
                            >
                                @lang('history.dateFilter.' . $filterCode)
                            </a>
                        @endforeach
                    </div>
                </span>
            </div>

            @if($tasks->total() == 0)
                <div class="alert alert-warning" role="alert">
                    @lang('history.RecordsNotFound')
                </div>
            @else
                <table class="table table-hover table-sm table-history">
                    <thead>
                    <tr>
                        <th class="history-column-title" scope="col">@lang('history.taskTable.Title')</th>
                        <th class="history-column-description" scope="col">@lang('history.taskTable.Description')</th>
                        <th class="history-column-date" scope="col">@lang('history.taskTable.Date')</th>
                        <th class="history-column-actions"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr data-task-id="{{ $task->id }}">
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->created_at->format('d.m.Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                            onclick="removeTask({{ $task->id }})"
                                        >
                                            <i class="fa fa-trash"></i>
                                            @lang('history.Delete')
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $tasks->appends(['filter-date' => $activeFilter['date']])->onEachSide(1)->links('pagination.default') }}
            @endif
        @endif
    </div>

    @push('head_css')
        <link href="{{ mix('css/history.css') }}" rel="stylesheet">
    @endpush

    @push('body_scripts')
        <script src="{{ mix('js/history.js') }}"></script>
    @endpush

@endsection
