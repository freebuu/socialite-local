<?php

namespace Kirbykot\LocalSocialite\Socialite;

use Illuminate\Contracts\Container\Container;
use Laravel\Socialite\Contracts\Factory;
use ReflectionClass;

class LocalSocialiteManager implements Factory
{
    private Container $container;
    private Factory $originalFactory;
    private bool $enabled;

    public function __construct(Container $container, Factory $originalFactory, bool $enabled)
    {
        $this->container = $container;
        $this->originalFactory = $originalFactory;
        $this->enabled = $enabled;
    }

    public function driver($driver = null)
    {
        $originalDriver = $this->originalFactory->driver($driver);
        if(! $this->enabled){
            return $originalDriver;
        }
        $reflection = new ReflectionClass($originalDriver);
        $properties = [];
        foreach ($reflection->getProperties() as $property){
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($originalDriver);
        }
        return (new LocalProvider(
            $this->container->make('request'),
            $properties['clientId'],
            $properties['clientSecret'],
            $properties['redirectUrl'],
            $properties['guzzle']
        ))
            ->with($properties['parameters'])
            ->scopes($properties['scopes'])
            ->originalDriver($driver)
            ->scopeSeparator($properties['scopeSeparator']);

    }

}