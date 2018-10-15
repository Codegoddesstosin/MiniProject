<?php



namespace App\Auth\Traits;

use Mail;
use App\UserLoginToken;
use App\Mail\MagicLoginRequested;

trait MagicAuth

{   
  //method to store token
     public  function storeToken()
      {

      	  

      	$this->token()->create([

      		'token' => str_random(255),


      	]);
         return $this;

      }

    //method to store magiclink
    public function sendMagicLink(array $options)

      {
          //accept an array of options to mail
         Mail::to($this)->send(new MagicLoginRequested($this, $options));
      }


      
    public function token()

	    {

	    return $this->hasOne(UserLoginToken::class);

	    }


}