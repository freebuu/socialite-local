<?php

namespace Kirbykot\LocalSocialite\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Kirbykot\LocalSocialite\SubjectRepository;

class LoginController
{
    public function show(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'client_id' => 'required | string',
            'redirect_uri' => 'required | url',
            'scope' => 'required | nullable |string',
            'response_type' => 'required | string',
            'state' => 'nullable | string',
            'original_driver' => 'nullable | string'
        ]);
        //TODO error page
        if($validator->failed()){
            return Response::json($validator->errors());
        }
        return View::make('local_socialite::login', $validator->validated());
    }

    public function login(Request $request, SubjectRepository $repository)
    {
        //TODO error page
        $data = Validator::make($request->input(), [
            'email' => 'required | email',
            'sub' => 'nullable | string',
            'name' => 'nullable | string',
            'scope' => 'nullable | string',
            'redirect_uri' => 'required | url'
        ])->validate();

        $query = http_build_query([
            'code' => $repository->create($data),
        ]);
        return Redirect::to($request->input('redirect_uri').'/?'.$query);
    }
}