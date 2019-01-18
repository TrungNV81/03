<?php

namespace App\Http\Controllers;

use App\Http\Services\LoginService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;

class LoginController extends Controller
{
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getLogin()
    {
        $logged = session('LOGGED');
        if (isset($logged)) {
            return redirect()->intended('');
        }
        return view('login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        return $this->loginService->postLogin($request);
    }
}
