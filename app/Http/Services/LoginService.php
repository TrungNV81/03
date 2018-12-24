<?php

namespace App\Http\Services;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;

class LoginService
{
    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin($request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required|min:6'
        ];
        $messages = [
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');

            if (Auth::attempt(['name' => $email, 'password' => $password])) {
                return redirect()->intended('/');
            } else {
                $errors = new MessageBag(['errorlogin' => 'Email or Password incorrect']);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
    }
}
