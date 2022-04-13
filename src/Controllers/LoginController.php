<?php

namespace Kirbykot\LocalSocialite\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Kirbykot\LocalSocialite\SubjectRepository;

class LoginController
{
    public function show(Request $request)
    {
        //TODO некрасиво
        return View::make('local_socialite::login', [
            'client_id' => $request->get('client_id'),
            'redirect_uri' => $request->get('redirect_uri'),
            'scope' => $request->get('scope'),
            'response_type' => $request->get('response_type'),
            'state' => $request->get('response_type'),
            'original_driver' => $request->get('original_driver')
        ]);
    }

    public function login(Request $request, SubjectRepository $repository)
    {
        //TODO вынести в сервис
        $key = $repository->save([
            'email' => $email = $request->input('email'),
            'sub' => $request->input('sub') ?? md5($email),
            'name' => $request->input('name') ?? mb_substr($email, 0, strpos($email, '@')) . '__name',
            'scope' => $request->input('scope'),
        ]);
        $query = http_build_query([
            'code' => $key,
        ]);
        return Redirect::to($request->input('redirect_uri').'/?'.$query);
    }
}