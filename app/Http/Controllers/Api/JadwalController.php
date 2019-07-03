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
        $statusKegiatan = $request->input('status_kegiatan') ?? '%%';
        $waktu = $request->input('waktu') ?? date("Y-m-d");
        $jadwalCollection = Jadwal::with('kapal')
                                  ->with('kapal.agen_pelayaran')
                                  ->where('status_kegiatan', 'like', $statusKegiatan)
                                  ->whereDate('waktu', $waktu)
                                  ->get();
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
     * @param Date waktu
     * @param string kota
     * @param enum<datang,berangkat> status_kegiatan
     * @param enum<datang,on_schedule,cancel> status_kapal
     * @param enum<check_in,boarding> status_tiket
     * @param string id_kapal
     * @return Jadwal jadwal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'waktu',
            'kota',
            'status_kegiatan',
            'status_kapal',
            'status_tiket',
            'id_kapal'
        ]);
        $validator = Validator::make($requestData, [
            'waktu' => 'required|date',
            'kota' => 'required|string',
            'status_kegiatan' => Rule::in('datang', 'berangkat'),
            'status_kapal' => Rule::in('on schedule', 'delay', 'cancel'),
            'status_tiket' => Rule::in('check in', 'boarding'),
            'id_kapal' => 'required|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            try{
                $jadwal = Jadwal::create($requestData);
                return response()->json($jadwal, 201);
            } catch(Exception $e){
                return response()->json(['message' => $e], 500);
            }
        }
        return response()->json([
            'message' => 'Data tidak valid',
            'errors' => $validator->errors()
        ], 400);
    }

    /**
     * Update jadwal by Id
     * @param Date waktu
     * @param string kota
     * @param enum<datang,berangkat> status_kegiatan
     * @param enum<datang,on_schedule,cancel> status_kapal
     * @param enum<check_in,boarding> status_tiket
     * @param string id_kapal
     * @return Jadwal jadwal
     */
    public function update(Request $request, Jadwal $jadwal){
        $requestData = $request->only([
            'waktu',
            'kota',
            'status_kegiatan',
            'status_kapal',
            'status_tiket',
            'id_kapal',
        ]);
        $validator = Validator::make($requestData, [
            'waktu' => 'required|date',
            'kota' => 'required|string',
            'status_kegiatan' => Rule::in('datang', 'berangkat'),
            'status_kapal' => Rule::in('on schedule', 'delay', 'cancel'),
            'status_tiket' => Rule::in('check in', 'boarding'),
            'id_kapal' => 'required|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            try{
                $isJadwalUpdated = $jadwal->update($requestData);
                if($isJadwalUpdated){
                    $jadwal = Jadwal::find($jadwal->id);
                    return response()->json($jadwal, 201);
                }
                return response()->json(['error' => 'Gagal mengupdate jadwal'], 500);
            } catch(Exception $e){
                return response()->json(['message' => $e], 500);
            }

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
        try{
            $isJadwalDeleted = $jadwal->delete();
            if($isJadwalDeleted) return response()->json(null, 204);
            return response()->json([
                'message' => 'Gagal menghapus jadwal',
            ], 500);
        } catch(Exception $e){
            return response()->json(['message' => $e], 500);
        }
    }
}
