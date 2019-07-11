<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller{

    /**
     * Get logged user's profile
     * @return User user
     */
    public function showProfile(Request $request){
        $user = auth()->user();
        return (new UserResource($user))->response()
                                        ->setStatusCode(200);
    }

    /**
     * Search data
     * @param String key
     * @param String query
     * @param int size
     * @return Collection<AgenPelayaran> searchResult
     */
    public function search(Request $request){
        $size = $request->input('size') ?? 10;
        $key = $request->input('key') ?? 'nama';
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : ''
                    : '%%';
        $paginatedSearchResult = User::where($key, 'like', $query)
                                     ->paginate($size);
        return UserResource::collection($paginatedSearchResult)
                           ->response()
                           ->setStatusCode(200);
    }
}
