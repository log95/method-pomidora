<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pomidor\CompletedTasks;
use App\Pomidor\Settings;
use Carbon\Carbon;


class MainApp extends Controller
{
    public function __construct()
    {
        $this->middleware('verified')->except('getInitData');
    }

    public function getInitData()
    {
        $isVerifiedUser = Auth::check() && Auth::user()->hasVerifiedEmail();
        $settings = [];
        $completedTask = [];

        if ($isVerifiedUser) {
            $completedTask = CompletedTasks::where('user_id', Auth::id())
                ->whereDate('created_at', '=', Carbon::today()->toDateString())
                ->get(['id', 'title', 'description'])
                ->toArray();

            $settingsObj = Settings::where('user_id', Auth::id())
                ->first([
                    'long_rest_duration',
                    'long_rest_via_count_pomidors',
                    'need_sound_timer_finished',
                    'pomidor_duration',
                    'short_rest_duration',
                ]);
            if ($settingsObj) {
                $settings = $settingsObj->toArray();
            }
        }

        if (!$settings) {
            $settingsObj = new Settings();
            $settings = $settingsObj->getAttributes();
        }

        return [
            'isVerifiedUser' => $isVerifiedUser,
            'completedTasks' => $completedTask,
            'settings' => $settings,
        ];
    }

    public function saveCompletedTask(Request $request)
    {
        $validatedData = $request->validate(CompletedTasks::VALIDATION_RULES);

        try {
            $task = CompletedTasks::create([
                'user_id' => Auth::id(),
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
            ]);

            return [
                'error' => false,
                'idTask' => $task->id,
            ];
        }
        catch (\Throwable $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function updateCompletedTask(int $idTask, Request $request)
    {
        $validatedData = $request->validate(CompletedTasks::VALIDATION_RULES);

        try {
            CompletedTasks::where('user_id', Auth::id())
                ->where('id', $idTask)
                ->update([
                    'title' => $validatedData['title'],
                    'description' => $validatedData['description'],
                ]);

            return [
                'error' => false,
            ];
        }
        catch (\Throwable $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function deleteCompletedTask(int $idTask)
    {
        try {
            CompletedTasks::where('user_id', Auth::id())
                ->where('id', $idTask)
                ->delete();

            return [
                'error' => false,
            ];
        }
        catch (\Throwable $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
