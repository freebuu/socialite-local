<?php


namespace Kirbykot\LocalSocialite\Socialite;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    public const IDENTIFIER = 'LOCAL';

    protected function getAuthUrl($state)
    {
        // TODO: Implement getAuthUrl() method.
    }

    protected function getTokenUrl()
    {
        // TODO: Implement getTokenUrl() method.
    }

    protected function getUserByToken($token)
    {
        // TODO: Implement getUserByToken() method.
    }

    protected function mapUserToObject(array $user)
    {
        // TODO: Implement mapUserToObject() method.
    }
}
