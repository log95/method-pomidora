<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class SocialAccountService extends Model
{
    /**
     * Get user id in out db based on social account data from provider.
     * @param \Laravel\Socialite\Two\User $socialAccountData
     * @param string $socialProvider
     * @return mixed
     */
    public function getUserIdBySocialAccountData(\Laravel\Socialite\Two\User $socialAccountData, string $socialProvider)
    {
        if (!$socialAccountData->getId()) {
            throw new \RuntimeException('Provider user id is empty');
        }

        $socialAccount = LinkedSocialAccount::where([
            ['provider_name', '=', $socialProvider],
            ['provider_user_id', '=', $socialAccountData->getId()],
        ])->first();

        if ($socialAccount) {
            return $socialAccount->user_id;
        }

        $socialEmail = $socialAccountData->getEmail();
        // Vkontakte store email in token body field
        if (!$socialEmail && ($socialAccountData instanceof \SocialiteProviders\Manager\OAuth2\User)) {
            $socialEmail = $socialAccountData->accessTokenResponseBody['email'];
        }
        if (!$socialEmail) {
            throw new \RuntimeException('Email in social service is must not be empty');
        }

        $user = User::where('email', $socialEmail)->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialAccountData->getName(),
                'email' => $socialEmail,
                'email_verified_at' => Date::now(),
            ]);
        } else if (!$user->hasVerifiedEmail()) {
            $user->update([
                'email_verified_at' => Date::now(),
            ]);
        }

        LinkedSocialAccount::create([
            'user_id' => $user->id,
            'provider_name' => $socialProvider,
            'provider_user_id' => $socialAccountData->getId(),
        ]);

        return $user->id;
    }
}
