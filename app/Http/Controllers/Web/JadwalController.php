<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Jadwal;

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
        $tanggal = $request->input('tangggal') ?? date('Y-m-d');
        $jadwalCollection = Jadwal::with('kapal')
                                  ->where('tujuan', 'Surabaya')
                                  ->whereDate('kedatangan', $tanggal)
                                  ->get();
        return view('jadwal.kedatangan', compact('jadwalCollection'));
    }

    /**
     * Show all jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatan
     */
    public function showJadwalKeberangkatan(Request $request){
        $tanggal = $request->input('tangggal') ?? date('Y-m-d');
        $jadwalCollection = Jadwal::with('kapal')
                                  ->where('asal', 'Surabaya')
                                  ->whereDate('keberangkatan', $tanggal)
                                  ->get();
        return view('jadwal.keberangkatan', compact('jadwalCollection'));
    }

    /**
     * Show create form
     * @return View createJadwal
     */
    public function create(Request $request){
        return view('jadwal.create');
    }
}
