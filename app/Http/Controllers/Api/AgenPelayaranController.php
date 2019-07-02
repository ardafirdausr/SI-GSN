<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rule;
use Validator;

use App\Models\AgenPelayaran;

class AgenPelayaranController extends Controller{

    /**
     * Show all agen_pelayaran
     * @return Collection<AgenPelayaran> agenPelayaranCollection
     */
    public function index(Request $request){
        $agenPelayaranCollection = AgenPelayaran::all();
        return response()->json($agenPelayaranCollection, 200);
    }

    /**
     * Show agen_pelayaran by Id
     * @param int id
     * @return AgenPelayaran agenPelayaran
     */
    public function show(Request $request, AgenPelayaran $agenPelayaran){
        return response()->json($agenPelayaran, 200);
    }

    /**
     * Create new agen_pelayaran
     * @param string nama
     * @param string loket
     * @return AgenPelayaran agenPelayaran
     */
    public function store(Request $request){
        $requestData = $request->only([
            'nama',
            'loket',
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string',
            'loket' => 'required|string|unique:agen_pelayaran,loket',
        ]);
        if($validator->passes()){
            $agenPelayaran = AgenPelayaran::create($requestData);
            return response()->json($agenPelayaran, 201);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Update agen_pelayaran by Id
     * @param string nama
     * @param string loket
     * @return AgenPelayaran agenPelayaran
     */
    public function update(Request $request, AgenPelayaran $agenPelayaran){
        $requestData = $request->only([
            'nama',
            'loket',
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string',
            'loket' => 'required|string|unique:agen_pelayaran,loket',
        ]);
        if($validator->passes()){
            $isAgenPelayaranUpdated = $agenPelayaran->update($requestData);
            if($isAgenPelayaranUpdated){
                $agenPelayaran = AgenPelayaran::find($agenPelayaran->id);
                return response()->json($agenPelayaran, 201);
            }
            return response()->json([
                'Gagal mengupdate agen_pelayaran'
            ], 500);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Delete agen_pelayaran by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, AgenPelayaran $agenPelayaran){
        $isAgenPelayaranDeleted = $agenPelayaran->delete();
        if($isAgenPelayaranDeleted) return response()->json(null, 204);
        return response()->json([
            'message' => 'Gagal menghapus agen_pelayaran',
        ], 500);
    }

    /**
     * Show agen_pelayaran's kapals by agen_pelayaran id
     * @param int id
     * @return Collection<Kapal> kapalCollection
     */
    public function showKapalByAgenPelayaranId(Request $request, AgenPelayaran $agenPelayaran){
        $kapalCollection = $agenPelayaran->kapal();
        return response()->json($kapalCollection, 200);
    }
}
