<?php

namespace FreeBuu\SocialiteLocal;

use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Psr\SimpleCache\CacheInterface;
use Illuminate\Cache\Repository as CacheRepository;

class SubjectRepository
{
    public const PREFIX = 'socialite_local';
    private CacheInterface $cache;

    private ?Closure $userCallback = null;

    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    public function create(array $data): string
    {
        //TODO model?
        //TODO original driver decorators
        //TODO pass original driver
        return $this->save([
            'user' => [
                'email' => $data['email'],
                'id' => $data['id'] ?? null,
                'name' => $data['name'] ?? null,
            ],
            'request' => [
                'scope' => $data['scope'] ?? '',
                'refresh_token' => $data['refresh_token'] ?? Hash::make(Str::random(8)),
                'access_token' => $key = $data['access_token'] ?? null,
                'expires_in' => $data['expires_in'] ?? 31536000,
            ]
        ], $key);
    }

    private function save(array $data, string $key = null): string
    {
        $key = $key ?? Hash::make(Str::random(8));
        $data['request']['access_token'] = $key;
        $this->cache->add($this->getCacheKey($key), $data);
        return $key;
    }

    public function find(string $key): ?array
    {
        return $this->cache->get($this->getCacheKey($key));
    }

    public function getRequest(string $key): ?array
    {
        $data = $this->find($key);
        if(! $data){
            return null;
        }
        return $data['request'];
    }

    public function getUser(string $key): ?array
    {
        $data = $this->find($key);
        if(! $data){
            return null;
        }
        $data = $data['user'];
        return $this->userCallback
            ? call_user_func($this->userCallback, $data)
            : [
                'id' => $data['id'] ?? random_int(1000, 10000),
                'uuid' => $data['uuid'] ?? vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4)),
                'email' => $email = $data['email'],
                'username' => $data['username'] ?? $email,
                'login' => $data['login'] ?? $email,
                'name' => $data['name'] ?? mb_substr($email, 0, strpos($email, '@')) . '_name',
                'avatar' => $data['avatar'] ?? null,
                'avatar_url' => $data['avatar_url'] ?? null
            ];
    }

    private function getCacheKey(string $key): string
    {
        return self::PREFIX.':'.$key;
    }

    public function setUserCallback(Closure $closure)
    {
        $this->userCallback = $closure;
    }
}