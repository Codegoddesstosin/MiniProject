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

      
       //method to send token 
     public function sendToken (Request $request, MagicAuthentication $auth)
     {
         $this->validateLogin($request);

          //request link from MagicAuthentication.php in traits, injected in the send token method
         $auth->requestLink();

         return redirect()->to($this->redirectOnRequested)->with('success', 'We have sent you a magic link!');

     }
     
     // validate
     protected function validateLogin(Request $request)
     {
         //validate the request
     	 $this->validate($request, [

           'email' => 'required|email|max:255|exists:users,email'

     	 ]);
     }


     public function validateToken(Request $request, UserLoginToken $token)

     {    
          $token->delete();
            //isexpiredat method checks if the createdat date has a differenc in secs greater than the expired date defined
           if ($token->isExpired()) {

             return redirect('/login/magic')->with('error', 'That magic link has expired');

           }
 

            
           if(!$token->belongsToEmail($request->email)){
               
               return redirect('/login/magic')->with('error', 'Invalid magic Link');

           }

        //login the user
       Auth::login($token->user, $request->remember);

        return redirect()->intended();
     }
}
