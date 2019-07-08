<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller{

    /**
	 * Set middleware for this controller
	 */
	public function __construct(){
		$this->middleware(['jwt-auth-refresh']);
	}

    /**
     * Get logged user's profile
     * @return User user
     */
    public function showProfile(Request $request){
        $user = auth()->user();
        return (new UserResource($user))->response()
                                        ->setStatusCode(200);
    }
}
