<?php

namespace FreeBuu\SocialiteLocal;

use FreeBuu\SocialiteLocal\Socialite\LocalProvider;
use Laravel\Socialite\Contracts\Provider;
use ReflectionClass;

class Interceptor
{
    private SubjectRepository $subjectRepository;
    private array $config;

    public function __construct(
        SubjectRepository $subjectRepository,
        array $config
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->config = $config;
    }

    public function changeProvider(Provider $originalProvider, $driver)
    {
        if (app()->environment('production') || $this->config['enabled'] !== true){
            return $originalProvider;
        }
        //TODO work with oauth1 providers
        $reflection = new ReflectionClass($originalProvider);
        $properties = [];
        foreach ($reflection->getProperties() as $property){
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($originalProvider);
        }
        $provider = (new LocalProvider(
            $properties['request'],
            $properties['clientId'],
            $properties['clientSecret'],
            $properties['redirectUrl'],
            $properties['guzzle']
        ));
        $provider
            ->with($properties['parameters'])
            ->scopes($properties['scopes'])
            ->originalDriver($driver)
            ->scopeSeparator($properties['scopeSeparator'])
            ->setSubjectRepository($this->subjectRepository);
        if($this->config['use_original_mapper'] === true){
            $userMapClosure = $reflection->getMethod('mapUserToObject')->getClosure($originalProvider);
            $provider->setUserMapClosure($userMapClosure);
        }
        return $provider;
    }
}