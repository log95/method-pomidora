<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Settings extends Controller
{
    public function __construct()
    {
        $this->middleware('verified')->only('save');
    }

    public function show()
    {
        $user = auth()->user();
        $settings = [];

        if ($user) {
            $settings = \App\Pomidor\Settings::find($user->id);
            if (!$settings) {
                $settingsObj = new \App\Pomidor\Settings();
                $settings = $settingsObj->getAttributes();
            }
        }

        return view('settings', ['settings' => $settings]);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate(\App\Pomidor\Settings::VALIDATION_RULES);

        $user = auth()->user();

        try {
            \App\Pomidor\Settings::updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );
            $saveStatus = 'Success';
        } catch (\Throwable $e) {
            $saveStatus = 'Error';
        }

        return redirect()->route('settings')->with('saveStatus', $saveStatus);
    }
}
