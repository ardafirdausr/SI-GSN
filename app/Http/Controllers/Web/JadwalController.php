<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Jadwal;
use App\Models\AgenPelayaran;
use App\Models\LogAktivitas;
use App\Http\Resources\JadwalResource;
use Rule;

class JadwalController extends Controller{

    /**
     * Set middleware for theese functions
     */
    public function __construct(){
        $this->middleware(['role:admin'])->except(['showTiketJadwal', 'showTiketJadwalList', 'update']);
        $this->middleware(['role:petugas agen'])->only(['showTiketJadwal', 'showTiketJadwalList']);
        $this->middleware(['permission:mengupdate jadwal'])->only(['update']);
    }

    /**
     * Show all jadwal
     * @return View jadwalView
     */
    public function index(Request $request){
        $tanggal = $request->input('tangggal') ?? date('Y-m-d');
        $size = $request->input('size') ?? 10;
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : ''
                    : '%%';
        $paginatedJadwal = Jadwal::with('kapal')
                                 ->with('kapal.agen_pelayaran')
                                 ->whereHas('kapal',function($kapal) use($query){
                                     $kapal->where('nama', 'like', $query);
                                   })
                                 ->orderBy('updated_at', 'desc')
                                 ->orderBy('waktu', 'desc')
                                 ->paginate($size);
        $topFiveJadwalLogs = LogAktivitas::where('log_type', 'App\Models\Jadwal')
                                               ->orderBy('created_at', 'desc')
                                               ->take(5)
                                               ->get();
        return view('jadwal.index', compact('paginatedJadwal', 'topFiveJadwalLogs', 'tanggal', 'query'));
    }

    /**
     * Show all jadwal kedatangan
     * @param Date date
     * @return View jadwalKedatangan
     */
    public function showJadwalKedatangan(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = 'Jadwal Kedatangan';
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->whereHas('kapal', function($kapal) use($query){
                                        $kapal->where('nama', 'like', $query);
                                    })
                                  ->where('status_kegiatan', 'datang')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        $topFiveJadwalLogs = LogAktivitas::where('log_type', 'App\Models\Jadwal')
                                        //  ->whereHas('jadwal', function($jadwal){
                                        //      $jadwal->where('status_kegiatan', 'berangkat');
                                        //    })
                                         ->orderBy('created_at', 'desc')
                                         ->take(5)
                                         ->get();
        return view('jadwal.jadwal', compact('paginatedJadwal', 'titleJadwal', 'topFiveJadwalLogs', 'tanggal'));
    }

    /**
     * Show all jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatan
     */
    public function showJadwalKeberangkatan(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = "Jadwal Keberangakatan";
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->whereHas('kapal', function($kapal) use($query){
                                      $kapal->where('nama', 'like', $query);
                                    })
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        $topFiveJadwalLogs = LogAktivitas::where('log_type', 'App\Models\Jadwal')
                                        //  ->whereHas('jadwal', function($jadwal){
                                        //     $jadwal->where('status_kegiatan', 'berangkat');
                                        //  })
                                         ->orderBy('created_at', 'desc')
                                         ->take(5)
                                         ->get();
        return view('jadwal.jadwal', compact('paginatedJadwal', 'titleJadwal', 'topFiveJadwalLogs', 'tanggal'));
    }

    public function showTiketJadwal(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = "Tiket Keberangakatan";
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->whereHas('kapal', function($kapal) use($query){
                                      $kapal->where('nama', 'like', $query);
                                    })
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        $topFiveJadwalLogs = LogAktivitas::where('log_type', 'App\Models\Jadwal')
                                        //  ->whereHas('jadwal', function($jadwal){
                                        //     $jadwal->where('status_kegiatan', 'berangkat');
                                        //  })
                                         ->orderBy('created_at', 'desc')
                                         ->take(5)
                                         ->get();
        return view('jadwal.tiket', compact('paginatedJadwal', 'titleJadwal', 'topFiveJadwalLogs', 'tanggal'));
    }

    /**
     * Show all jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatan
     */
    public function showJadwalKedatanganList(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = "Kedatangan";
        $jadwalCollection = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'datang')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->get();
        return view('jadwal.jadwal-list', compact('jadwalCollection', 'titleJadwal', 'tanggal'));
    }

    /**
     * Show List jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatanList
     */
    public function showJadwalKeberangkatanList(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = "Keberangakatan";
        $jadwalCollection = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->get();
        return view('jadwal.jadwal-list', compact('jadwalCollection', 'titleJadwal', 'tanggal'));
    }

    /**
     * Show List jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatanList
     */
    public function showTiketJadwalList(Request $request){
        $tanggal = $request->input('tanggal') ?? date('Y-m-d');
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : '%%'
                    : '%%';
        $titleJadwal = "Tiket Pelayaran";
        $jadwalCollection = Jadwal::with('kapal.agen_pelayaran')
                                  ->with('kapal')
                                  ->whereHas('kapal', function($kapal) use($query){
                                      $kapal->where('nama', 'like', $query);
                                    })
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $tanggal)
                                  ->orderBy('waktu', 'asc')
                                  ->get();
        return view('jadwal.tiket-list', compact('jadwalCollection', 'titleJadwal', 'tanggal'));
    }


    /**
     * Create new jadwal
     * @param Date waktu
     * @param string kotalislistt
     * @param enum<datang,berangkat> status_kegiatan
     * @param enum<datang,on_schedule,cancel> status_kapal
     * @param enum<check_in,boarding> status_tiket
     * @param string kapal_id
     * @return Jadwal jadwal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'tanggal',
            'jam',
            'kota',
            'status_kegiatan',
            'status_kapal',
            'status_tiket',
            'kapal_id'
        ]);
        $validator = Validator::make($requestData, [
            'tanggal' => 'required|date|after_or_equal:'.date('Y/m/d'),
            'jam' => 'required',
            'kota' => 'required|string',
            'status_kegiatan' => Rule::in('datang', 'berangkat'),
            'status_kapal' => Rule::in('on schedule', 'delay', 'cancel'),
            'status_tiket' => Rule::in('check in', 'boarding'),
            'kapal_id' => 'required|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            try{
                $requestData['waktu'] = $requestData['tanggal'].' '.$requestData['jam'];
                $jadwal = Jadwal::create($requestData);
                return redirect()->route('web.jadwal.index')
                                 ->with(['successMessage' => 'Berhasil menambahkan jadwal baru']);
            } catch(Exception $e){
                return redirect()->back()
                                 ->withInput()
                                 ->with([
                                     'errorMessage' => 'Server Error',
                                     'failedCreate' => true
                                 ]);
            }
        }
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput()
                         ->with([
                             'errorMessage' => 'Data Tidak valid',
                             'failedCreate' => true
                         ]);
    }

    /**
     * Update jadwal by Id
     * @param Date waktu
     * @param string kota
     * @param enum<datang,berangkat> status_kegiatan
     * @param enum<datang,on_schedule,cancel> status_kapal
     * @param enum<check_in,boarding> status_tiket
     * @param string kapal_id
     * @return Jadwal jadwal
     */
    public function update(Request $request, Jadwal $jadwal){
        $requestData = $request->only([
            'tanggal',
            'jam',
            'kota',
            'status_kegiatan',
            'status_kapal',
            'status_tiket',
            'kapal_id',
        ]);
        // return response()->json($requestData);
        $validator = Validator::make($requestData, [
            'tanggal' => 'sometimes|date',
            'jam' => 'sometimes',
            'kota' => 'sometimes|string',
            'status_kegiatan' => Rule::in('datang', 'berangkat'),
            'status_kapal' => Rule::in('on schedule', 'delay', 'cancel'),
            'status_tiket' => Rule::in('check in', 'boarding'),
            'kapal_id' => 'sometimes|integer|exists:kapal,id',
        ]);
        if($validator->passes()){
            try{
                if(isset($requestData['tanggal']) && isset($requestData['jam'])){
                    $requestData['waktu'] = $requestData['tanggal'].' '.$requestData['jam'];
                }
                $isJadwalUpdated = $jadwal->update($requestData);
                if($isJadwalUpdated){
                    $jadwal = Jadwal::find($jadwal->id);
                    return redirect()->back()
                                     ->with(['successMessage' => 'Berhasil mengupdate jadwal']);
                }
                return redirect()->back()
                                 ->withInput()
                                 ->with([
                                     'errorMessage' => 'Gagal mengupdate jadwal',
                                     'failedUpdate' => true
                                 ]);
            } catch(Exception $e){
                return redirect()->back()
                                 ->withInput()
                                 ->with([
                                     'errorMessage' => 'Server error',
                                     'failedUpdate' => true
                                 ]);
            }

        }
        return redirect()->back()
                         ->withInput()
                         ->with([
                             'errorMessage' => 'Data tidak valid',
                             'failedUpdate' => true
                         ])
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
                return redirect()->back()
                                 ->with(['successMessage' => 'Berhasil menghapus jadwal']);
            };
            return redirect()->back()
                             ->with(['errorMessage' => 'Gagal menghapus jadwal']);
        } catch(Exception $e){
            return redirect()->back()
                             ->with(['errorMessage' => 'Server error']);
        }
    }
}
