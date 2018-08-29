<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\UserLoginToken;
use Illuminate\Http\Request;
use App\Auth\MagicAuthentication;
use App\Http\Controllers\Controller;

class MagicLoginController extends Controller

{    

    protected $redirectOnRequested = '/login/magic';


     public function show()
     {
     	return view('auth.magic.login');
     }

     public function sendToken (Request $request, MagicAuthentication $auth)
     {
         $this->validateLogin($request);

         $auth->requestLink();

         return redirect()->to($this->redirectOnRequested)->with('success', 'We have sent you a magic link!');

     }

     protected function validateLogin(Request $request)
     {
     	 $this->validate($request, [

           'email' => 'required|email|max:255|exists:users,email'

     	 ]);
     }


     public function validateToken(Request $request, UserLoginToken $token)

     {
          $token->delete();

           if ($token->isExpired()) {

             return redirect('/login/magic')->with('error', 'That magic link has expired');

           }

           if(!$token->belongsToEmail($request->email)){
               
               return redirect('/login/magic')->with('error', 'Invalid magic Link');

           }

       Auth::login($token->user, $request->remember);

        return redirect()->intended();
     }
}
