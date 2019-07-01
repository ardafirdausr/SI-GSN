<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rule;
use Validator;

use App\Models\Maskapai;

class MaskapaiController extends Controller{

    /**
     * Show all maskapai
     * @return Collection<Maskapai> maskapaiCollection
     */
    public function index(Request $request){
        $maskapaiCollection = Maskapai::all();
        return response()->json($maskapaiCollection, 200);
    }

    /**
     * Show maskapai by Id
     * @param int id
     * @return Maskapai maskapai
     */
    public function show(Request $request, Maskapai $maskapai){
        return response()->json($maskapai, 200);
    }

    /**
     * Create new maskapai
     * @param string nama
     * @param string loket
     * @return Maskapai maskapai
     */
    public function store(Request $request){
        $requestData = $request->only([
            'nama',
            'loket',
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string',
            'loket' => 'required|string|unique:maskapai,loket',
        ]);
        if($validator->passes()){
            $maskapai = Maskapai::create($requestData);
            return response()->json($maskapai, 201);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Update maskapai by Id
     * @param string nama
     * @param string loket
     * @return Maskapai maskapai
     */
    public function update(Request $request, Maskapai $maskapai){
        $requestData = $request->only([
            'nama',
            'loket',
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string',
            'loket' => 'required|string|unique:maskapai,loket',
        ]);
        if($validator->passes()){
            $isMaskapaiUpdated = $maskapai->update($requestData);
            if($isMaskapaiUpdated){
                $maskapai = Maskapai::find($maskapai->id);
                return response()->json($maskapai, 201);
            }
            return response()->json([
                'Gagal mengupdate maskapai'
            ], 500);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Delete maskapai by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, Maskapai $maskapai){
        $isMaskapaiDeleted = $maskapai->delete();
        if($isMaskapaiDeleted) return response()->json(null, 204);
        return response()->json([
            'message' => 'Gagal menghapus maskapai',
        ], 500);
    }

    /**
     * Show maskapai's kapals by maskapai id
     * @param int id
     * @return Collection<Kapal> kapalCollection
     */
    public function showKapalByMaskapaiId(Request $request, Maskapai $maskapai){
        $kapalCollection = $maskapai->kapal();
        return response()->json($kapalCollection, 200);
    }
}
