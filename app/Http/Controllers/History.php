<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Pomidor\CompletedTasks;

class History extends Controller
{
    const TASKS_PER_PAGE = 50;

    const FILTERS = [
        'date' => [
            'today',
            'yesterday',
            'last_week',
            'last_month',
            'for_all_time',
        ],
    ];

    const DEFAULT_DATE_FILTER = 'today';


    public function show(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return view('history');
        }

        $filterDate = $request->get('filter-date');
        if (!$filterDate || !in_array($filterDate, self::FILTERS['date'])) {
            $filterDate = self::DEFAULT_DATE_FILTER;
        }

        $queryBuilder = CompletedTasks::where('user_id', $user->id);

        switch ($filterDate)
        {
            case 'today':
                $queryBuilder->whereDate('created_at', '=', Carbon::today()->toDateString());
                break;

            case 'yesterday':
                $queryBuilder->whereDate('created_at', '=', Carbon::yesterday()->toDateString());
                break;

            case 'last_week':
                $queryBuilder->whereDate('created_at', '>=', Carbon::today()->subWeek());
                break;

            case 'last_month':
                $queryBuilder->whereDate('created_at', '>=', Carbon::today()->subMonth());
                break;
        }

        $queryBuilder->orderBy('created_at', 'desc');

        $tasks = $queryBuilder->paginate(self::TASKS_PER_PAGE);

        return view('history', [
            'tasks' => $tasks,
            'filters' => self::FILTERS,
            'activeFilter' => [
                'date' => $filterDate,
            ]
        ]);
    }
}
