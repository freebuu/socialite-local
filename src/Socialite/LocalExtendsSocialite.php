<?php


namespace Kirbykot\LocalSocialite\Socialite;

use SocialiteProviders\Manager\SocialiteWasCalled;

class LocalExtendsSocialite
{
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(Provider::IDENTIFIER, Provider::class);
    }
}
