<?php

namespace Kirbykot\LocalSocialite\Socialite;

use Closure;
use Illuminate\Support\Facades\URL;
use Kirbykot\LocalSocialite\SubjectRepository;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class LocalProvider extends AbstractProvider
{
    protected $stateless = true;

    protected ?Closure $userMapClosure = null;

    private ?SubjectRepository $subjectRepository = null;

    public function originalDriver(string $driver)
    {
        $this->parameters['original_driver'] = $driver;
        return $this;
    }

    public function scopeSeparator(string $separator)
    {
        $this->scopeSeparator = $separator;
        return $this;
    }

    public function setSubjectRepository(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
        return $this;
    }

    private function subjectRepository()
    {
        if(! $this->subjectRepository){
            throw new \RuntimeException('Subject repository not set');
        }
        return $this->subjectRepository;
    }

    public function setUserMapClosure(Closure $userMapClosure)
    {
        $this->userMapClosure = $userMapClosure;
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
        $data = $this->getSubjectByCode($code)['request'];
        return [
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires_in' => $data['expires_in'],
            'scope' => $data['scope']
        ];
    }

    protected function getUserByToken($token)
    {
        return $this->getSubjectByCode($token)['user'];
    }

    protected function mapUserToObject(array $user)
    {
        return $this->userMapClosure
            ? call_user_func($this->userMapClosure, $user)
            : $this->defaultUserMap($user);
    }

    private function getSubjectByCode(string $code): array
    {
        if(! $subject = $this->subjectRepository()->find($code)){
            throw new \RuntimeException('Cannot find subject with code ' . $code);
        }
        return $subject;
    }

    private function defaultUserMap(array $user): User
    {
        $userData = collect($user);
        $userObject = (new User())->setRaw($userData->toArray());
        return $userObject->map([
            'id'       => $userData->get('id'),
            'name'     => $userData->get('name'),
            'nickname' => $userData->get('name'),
            'email'    => $userData->get('email'),
        ]);
    }
}