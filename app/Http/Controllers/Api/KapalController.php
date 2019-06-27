<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rule;
use Validator;

use App\Models\Kapal;

class KapalController extends Controller{

    /**
     * Show all kapal
     * @return Collection<Kapal> kapalCollection
     */
    public function index(Request $request){
        $kapalCollection = Kapal::all();
        return response()->json($kapalCollection, 200);
    }

    /**
     * Show kapal by Id
     * @param int id
     * @return Kapal kapal
     */
    public function show(Request $request, Kapal $kapal){
        return response()->json($kapal, 200);
    }

    /**
     * Create new kapal
     * @param string kode
     * @param string nama
     * @param int id_maskapai
     * @return Kapal kapal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'kode',
            'nama',
            'id_maskapai'
        ]);
        $validator = Validator::make($requestData, [
            'kode' => 'required|string|unique:kapal',
            'nama' => 'required|string',
            'id_maskapai' => 'required|integer|exists:maskapai,id'
        ]);
        if($validator->passes()){
            $kapal = Kapal::create($requestData);
            return response()->json($kapal, 201);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            $validator->errors()
        ], 400);
    }

    /**
     * Update kapal by Id
     * @param string kode
     * @param string nama
     * @param int id_maskapai
     * @return Kapal kapal
     */
    public function update(Request $request, Kapal $kapal){
        $isKodeIdentic = $kapal->kode == $request->input('kode');
        $requestData = null;
        if($isKodeIdentic){
            $requestData = $request->only(['nama', 'id_maskapai']);
            $validator = Validator::make($requestData, [
                'nama' => 'required|string',
                'id_maskapai' => 'required|integer|exists:maskapai,id'
            ]);
        }
        else{
            $requestData = $request->only([
                'kode',
                'nama',
                'id_maskapai'
            ]);
            $validator = Validator::make($requestData, [
                'kode' => 'required|string|unique:kapal',
                'nama' => 'required|string',
                'id_maskapai' => 'required|integer|exists:maskapai,id'
            ]);
        }
        if($validator->passes()){
            $isKapalUpdated = $kapal->update($requestData);
            if($isKapalUpdated) return response()->json($kapal, 201);
            return response()->json(['message' => 'Gagal mengupdate data kapal'], 500);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            $validator->errors()
        ], 400);
    }

    /**
     * Delete kapal by Id
     * @return null
     */
    public function destroy(Request $request, Kapal $kapal){
        $isKapalDeleted = $kapal->delete();
        if($isKapalDeleted) return response()->json(null, 204);
        return response()->json(['message' => 'Gagal menghapus jadwal'], 500);
    }
}
