<?php

namespace Kirbykot\LocalSocialite\Socialite;

use Kirbykot\LocalSocialite\Interceptor;
use Laravel\Socialite\SocialiteManager;

class LocalSocialiteManager extends SocialiteManager
{
    private ?Interceptor $interceptor;

    public function driver($driver = null)
    {
        $originalProvider = parent::driver($driver);
        return $this->interceptor
            ? $this->interceptor->changeProvider($originalProvider, $driver)
            : $originalProvider;
    }

    public function setInterceptor(Interceptor $interceptor)
    {
        $this->interceptor = $interceptor;
        return $this;
    }
}