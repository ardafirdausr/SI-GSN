<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use JWTAuth;
use Validator;

class AuthController extends Controller{

  /**
	 * Constructor
	 * * Set middleware for controller functions
	 */
	public function __construct(){
		$this->middleware(['jwt-auth-refresh'])->only(['logout']);
	}

	/**
	 * Login user
	 */
	public function login(Request $request){
		$validator = Validator::make($request->only(['username', 'password']), [
			'username' => 'required|string',
			'password'=> 'required|string'
		]);
		if($validator->passes()) {
			$credentials = $request->only('username', 'password');
			try {
				if (! $token = JWTAuth::attempt($credentials)) {
					return response()->json(['message' => 'Username atau Password salah'], 400);
				}
			}
			catch (JWTException $e) {
				return response()->json(['message' => 'Gagal membuat token'], 500);
			}
			$user = auth()->user();
			$role = $user->getRoleNames()->first();
			if($role == 'petugas terminal'){
				return (new UserResource($user))->additional([
																						'meta' => compact('token'),
																						'message' => 'Login Berhasil'
																					])
																				->response()
																				->setStatusCode(200);
			}
			return response()->json(['message' => 'Hanya petugas terminal yang dapat mengakses aplikasi ini'], 403);
		}
		$errors = $validator->errors();
		return response()->json([
			'message'  => 'Data tidak valid',
			'errors' => $errors
		], 400);
	}

	/**
	 * Logout User
	 * * Add token to blacklist
	 */
	public function logout(Request $request) {
		$token = $request->bearerToken();
		try {
			JWTAuth::invalidate($token);
			return response()->json(['message'=> 'Logout berhasil'], 200);
		} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json([
				'message'  => 'Data tidak valid',
				'errors' => $errors
			], 500);
		}
	}
}
