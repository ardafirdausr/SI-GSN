<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KapalResource;
use App\Http\Resources\BasicResource;
use Rule;
use Validator;

use App\Models\Kapal;

class KapalController extends Controller{

    /**
	 * Constructor
	 * * Set middleware for controller functions
	 */
	public function __construct(){
		$this->middleware(['jwt-auth-refresh']);
	}

    /**
     * Show all kapal
     * @return Collection<Kapal> kapalCollection
     */
    public function index(Request $request){
        $size = $request->input('size') ?? 10;
        $kapalCollection = Kapal::paginate($size);
        return KapalResource::collection($kapalCollection)->response()
                                                          ->setStatusCode(200);
    }

    /**
     * Show kapal by Id
     * @param int id
     * @return Kapal kapal
     */
    public function show(Request $request, Kapal $kapal){
        return (new KapalResource($kapal))->response()
                                        ->setStatusCode(200);
    }

    /**
     * @param int size
     * @return Collection<Jadwal> paginatedJadwal
     */
    public function showJadwalByKapalId(Request $request, Kapal $kapal){
        $size = $request->input('size');
        $paginatedJadwal = $kapal->jadwal()->paginate($size);
        return BasicResource::collection($paginatedJadwal)
                             ->response()
                             ->setStatusCode(200);
    }
}
