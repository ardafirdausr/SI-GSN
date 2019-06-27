<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Rule;
use Validator;

use App\Models\Jadwal;

class JadwalController extends Controller{

    /**
     * Show all jadwal
     * @param enum tipe
     * @return Collection<Jadwal> jadwalCollection
     */
    public function index(Request $request){
        $tipe = $request->input('tipe');
        $tanggal = $request->input('tanggal') ?? date("d-m-Y");
        $tanggalAktif = new Carbon($tanggal);
        $jadwalCollection = null;
        switch($tipe){
            case 'keberangkatan':
                $jadwalCollection = Jadwal::where('asal', 'Surabaya')->get();
                break;
            case 'kedatangan':
                $jadwalCollection = Jadwal::where('tujuan', 'Surabaya')->get();
                break;
            default:
                $jadwalCollection = Jadwal::all();
        }
        $jadwalCollection = Jadwal::get();
        return response()->json($jadwalCollection, 200);
    }

    /**
     * Show jadwal by Id
     * @param int id
     * @return Jadwal jadwal
     */
    public function show(Request $request, Jadwal $jadwal){
        return response()->json($jadwal, 200);
    }

    /**
     * Create new jadwal
     * @param string asal
     * @param string tujuan
     * @param string keberangkatan
     * @param string kedatangan
     * @param enum status
     * @param int id_kapal
     * @return Jadwal jadwal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'asal',
            'tujuan',
            'keberangkatan',
            'kedatangan',
            'status',
            'id_kapal',
        ]);
        $validator = Validator::make($requestData, [
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'keberangkatan' => 'required|date',
            'kedatangan' => 'required|after:'.$requestData['keberangkatan'],
            'status' => Rule::in('on schedule', 'delay', 'cancel'),
            'id_kapal' => 'required|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            $jadwal = Jadwal::create($requestData);
            return response()->json($jadwal, 201);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Update jadwal by Id
     * @param string asal
     * @param string tujuan
     * @param string keberangkatan
     * @param string kedatangan
     * @param enum status
     * @param int id_kapal
     * @return Jadwal jadwal
     */
    public function update(Request $request, Jadwal $jadwal){
        $requestData = $request->only([
            'asal',
            'tujuan',
            'keberangkatan',
            'kedatangan',
            'status',
            'id_kapal',
        ]);
        $validator = Validator::make($requestData, [
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'keberangkatan' => 'required|date',
            'kedatangan' => 'required|date',
            'status' => Rule::in('on schedule', 'delay', 'cancel'),
            'id_kapal' => 'required|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            $isJadwalUpdated = $jadwal->update($requestData);
            if($isJadwalUpdated){
                $jadwal = Jadwal::find($jadwal->id);
                return response()->json($jadwal, 201);
            }
            return response()->json([
                'Gagal mengupdate jadwal'
            ], 500);
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Delete jadwal by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, Jadwal $jadwal){
        $isJadwalDeleted = $jadwal->delete();
        if($isJadwalDeleted) return response()->json(null, 204);
        return response()->json([
            'message' => 'Gagal menghapus jadwal',
        ], 500);
    }
}
