<?php

namespace Kirbykot\LocalSocialite;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubjectRepository
{
    public const PREFIX = 'local_socialite';

    public function save(array $data): string
    {
        $key = Hash::make(Str::random(8));
        Cache::add(self::PREFIX.':'.$key, $data);
        return $key;
    }

    public function find(string $key): ?array
    {
        return Cache::get(self::PREFIX.':'.$key);
    }
}