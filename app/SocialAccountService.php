<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccountService extends Model
{
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
