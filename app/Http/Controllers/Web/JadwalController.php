<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Jadwal;
use App\Models\AgenPelayaran;

class JadwalController extends Controller{

    /**
     * Show all jadwal
     * @return View jadwalView
     */
    public function index(Request $request){
        $tanggal = $request->input('tangggal') ?? date('Y-m-d');
        $jadwalCollection = Jadwal::get();
        return view('jadwal.index', compact('jadwalCollection'));
    }

    /**
     * Show all jadwal kedatangan
     * @param Date date
     * @return View jadwalKedatangan
     */
    public function showJadwalKedatangan(Request $request){
        $waktu = $request->input('waktu') ?? date('Y-m-d');
        $titleJadwal = 'Jadwal Kedatangan';
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'datang')
                                  ->whereDate('waktu', $waktu)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        return view('jadwal.jadwal', compact('paginatedJadwal', 'titleJadwal'));
    }

    /**
     * Show all jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatan
     */
    public function showJadwalKeberangkatan(Request $request){
        $waktu = $request->input('waktu') ?? date('Y-m-d');
        $titleJadwal = "Jadwal Keberangakatan";
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $waktu)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        return view('jadwal.jadwal', compact('paginatedJadwal', 'titleJadwal'));
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
                return redirect()->route('web.jadwal.index')
                                 ->with(['successMessage' => 'Berhasil menambahkan jadwal baru']);
            } catch(Exception $e){
                return redirect()->route('web.jadwal.index')
                                 ->with(['errorMessage' => 'Server Error']);
            }
        }
        return redirect()->route('web.jadwal.index')
                         ->with(['errorMessage' => 'Data tidak valid'])
                         ->withErrors($validator);
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
                    return redirect()->route('web.jadwal.index')
                                     ->with(['successMessage' => 'Berhasil mengupdate jadwal']);
                }
                return redirect()->route('web.jadwal.index')
                                 ->with(['errorMessage' => 'Gagal mengupdate jadwal']);
            } catch(Exception $e){
                return redirect()->route('web.jadwal.index')
                                 ->with(['errorMessage' => 'Server error']);
            }

        }
        return redirect()->route('web.jadwal.index')
                         ->with(['errorMessage' => 'Data tidak valid'])
                         ->withErrors($validator);
    }

    /**
     * Delete jadwal by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, Jadwal $jadwal){
        try{
            $isJadwalDeleted = $jadwal->delete();
            if($isJadwalDeleted) {
                return redirect()->route('web.jadwal.index')
                                 ->with(['successMessage' => 'Berhasil menhapus jadwal']);
            };
            return redirect()->route('web.jadwal.index')
                             ->with(['errorMessage' => 'Gagal menghapus jadwal']);
        } catch(Exception $e){
            return redirect()->route('web.jadwal.index')
                             ->with(['errorMessage' => 'Server error']);
        }
    }
}
