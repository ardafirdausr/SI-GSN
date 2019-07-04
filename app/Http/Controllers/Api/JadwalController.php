<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Rule;
use Validator;

use App\Models\Jadwal;
use App\Http\Resources\JadwalResource;

class JadwalController extends Controller{

    /**
     * Show all jadwal
     * @param enum tipe
     * @return Collection<Jadwal> jadwalCollection
     */
    public function index(Request $request){
        $statusKegiatan = $request->input('status_kegiatan') ?? '%%';
        $waktu = $request->input('waktu') ?? date("Y-m-d");
        $size =  $request->input('size') ?? 10;
        $paginatedJadwal = Jadwal::where('status_kegiatan', 'like', $statusKegiatan)
                                 ->whereDate('waktu', $waktu)
                                 ->paginate($size);
        return JadwalResource::collection($paginatedJadwal)
                             ->response()
                             ->setStatusCode(200);
    }

    /**
     * Show jadwal by Id
     * @param int id
     * @return Jadwal jadwal
     */
    public function show(Request $request, Jadwal $jadwal){
        return (new JadwalResource($jadwal))->response()
                                            ->setStatusCode(200);
    }

    /**
     * Update jadwal by Id
     * @param enum<datang,on_schedule,cancel> status_kapal
     * @param enum<check_in,boarding> status_tiket
     * @return Jadwal jadwal
     */
    public function update(Request $request, Jadwal $jadwal){
        $requestData = $request->only([
            'status_kapal',
            'status_tiket',
        ]);
        $validator = Validator::make($requestData, [
            'status_kapal' => Rule::in('on schedule', 'delay', 'cancel'),
            'status_tiket' => Rule::in('check in', 'boarding'),
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
}
