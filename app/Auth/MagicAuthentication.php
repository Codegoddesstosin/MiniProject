<?php 

namespace App\Auth;

use App\User;
use Illuminate\Http\Request;  

class MagicAuthentication

{
	protected $request;

    
    protected $identifier = 'email';



	public function __construct(Request $request)
	{
		$this->request = $request;
	}



     //method to request link
	public function requestLink()
	{

	     //pluck out the user by the email(which is the id set above)
        $user = $this->getUserByIdentifier($this->request->get($this->identifier));
         //delete existing token before a new one is generated
        $user->token()->delete();
        
        $user->storeToken()->sendMagicLink([
           'remember' => $this->request->has('remember'),
           'email' => $user->email,

        ]);
	}


  	protected function getUserByIdentifier($value)
	{
		//look up the user
	return User::where($this->identifier, $value)->firstorFail();
	} 

}