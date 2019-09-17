<?php

namespace App\Http\Controllers\Auth;

use App\SocialAccountService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->scopes(['email'])->redirect();
    }

    public function handleProviderCallback(SocialAccountService $socialAccountService, string $provider)
    {
        try {
            $socialUserAccount = Socialite::driver($provider)->user();
            $idUser = $socialAccountService->getUserIdBySocialAccountData($socialUserAccount, $provider);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->to('/')->with('authProviderError', true);
        }

        Auth::loginUsingId($idUser, true);

        return redirect()->to('/');
    }
}
