<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgenPelayaranResource;
use App\Http\Resources\BasicResource;
use Rule;
use Validator;

use App\Models\AgenPelayaran;

class AgenPelayaranController extends Controller{

    /**
	 * Constructor
	 * * Set middleware for controller functions
	 */
	public function __construct(){
		$this->middleware(['jwt-auth-refresh']);
	}

    /**
     * Show all agen_pelayaran
     * @param int size
     * @return Collection<AgenPelayaran> agenPelayaranCollection
     */
    public function index(Request $request){
        $size = $request->input('size');
        $agenPelayaranCollection = AgenPelayaran::paginate($size);
        return AgenPelayaranResource::collection($agenPelayaranCollection)
                                    ->response()
                                    ->setStatusCode(200);
    }

    /**
     * Show agen_pelayaran by Id
     * @param int id
     * @return AgenPelayaran agenPelayaran
     */
    public function show(Request $request, AgenPelayaran $agenPelayaran){
        return (new AgenPelayaranResource($agenPelayaran))->response()
                                                          ->setStatusCode(200);
    }

    /**
     * Show kapal by AgenPelayaran Id
     * @param int agenPelayaran
     * @return Collection<> Collection
     **/
    public function showKapalByAgenPelayaranId(Request $request, AgenPelayaran $agenPelayaran){
        $size = $request->input('size') ?? 10;
        $paginatedKapal = $agenPelayaran->kapal()->paginate(10);
        return BasicResource::collection($paginatedKapal)
                            ->response()
                            ->setStatusCode(200);
    }

    /**
     * Show by AgenPelayaran Id
     * @param int agenPelayaran
     * @return Collection<> Collection
     **/
    public function showJadwalByAgenPelayaranId(Request $request, AgenPelayaran $agenPelayaran){
        $size = $request->input('size') ?? 10;
        $paginatedJadwal = $agenPelayaran->jadwal()->with('kapal')->paginate(10);
        return BasicResource::collection($paginatedJadwal)
                            ->response()
                            ->setStatusCode(200);
    }
}