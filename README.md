# Socialite Local
## Introduction
The library is used to simulate an OAuth server locally. All calls to the Socialite are intercepted and replaced by a local driver. Only installation is enough to use - no additional configuration in most cases.

## Installation
- Require Socialite v4 or v5 and OAuth2 provider (OAuth1 providers not supported for now)
- Use Composer to install: `composer require --dev freebuu/socialite-local`

**:warning: WARNING: install this package only as dev dependency due to security reasons.**

By default, the package is disabled in production (when `APP_ENV=production`). You can explicity control if the interceptor is enabled by setting `SOCIALITE_LOCAL_ENABLED=true` (or `false`) in your environment file.

## Usage
Just use socialite as usual:
```php
Socialite::driver('github')->redirect()
```
You will be redirected to local page - where you can set email, username, id, etc. for subject. After submitting form you can get socialite user as usual - with previously entered data.
```php
Socialite::driver('github')->user()
```

## Additional configuration
### Server response
If you need to imitate user structure from server - it can be achieved with `afterResolving` callback   
```php
public function register()
{
    $this->app->afterResolving('socialite_local.subject_repository', function ($r){
        $r->setUserCallback(function ($data){
            //data is array coming from login form
            //return array with user info
            return [
                'id' => $data['id'] ?? random_int(1000, 10000),
                'uuid' => $data['uuid'] ?? vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4)),
                'email' => $email = $data['email'],
                'username' => $data['username'] ?? $email,
                'name' => $data['name'] ?? mb_substr($email, 0, strpos($email, '@')) . '_name',
            ];
        });
    });
}
```
### User mapper
By default, library use original driver mapper - to map server answer to User model. You can disable this behavior by setting `SOCIALITE_LOCAL_USE_ORIGINAL_MAPPER` to false