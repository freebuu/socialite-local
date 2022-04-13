<?php

namespace Kirbykot\LocalSocialite\Socialite;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Kirbykot\LocalSocialite\SubjectRepository;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class LocalProvider extends AbstractProvider
{
    protected $stateless = true;

    public function originalDriver($driver)
    {
        $this->parameters['original_driver'] = $driver;
        return $this;
    }

    public function scopeSeparator($separator)
    {
        $this->scopeSeparator = $separator;
        return $this;
    }

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(URL::route('local_socialite.show'), $state);
    }

    protected function getTokenUrl()
    {
        return '';
    }

    public function getAccessTokenResponse($code)
    {
        //TODO подумать над этой частью
        $repository = App::make(SubjectRepository::class);
        $data = $repository->find($code);
        return [
            'access_token' => $code,
            'refresh_token' => 'no_token',
            'expires_in' => 31536000,
            'scope' => $data['scope']
        ];
    }

    protected function getUserByToken($token)
    {
        $repository = App::make(SubjectRepository::class);
        return $repository->find($token);
    }

    protected function mapUserToObject(array $user)
    {
        $user = collect($user);
        return (new User())->setRaw($user->toArray())->map([
            'id'       => $user->get('sub'),
            'name'     => $user->get('name'),
            'email'    => $user->get('email'),
        ]);
    }
}