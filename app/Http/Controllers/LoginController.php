<?php

namespace App\Http\Controllers;

use App\Http\Services\LoginService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function getLogin()
    {
        $logged = session('LOGGED');
        if (isset($logged)) {
            return redirect()->intended('');
        }
        return view('login');
    }

    public function postLogin(Request $request)
    {
        return $this->loginService->postLogin($request);
    }
}
