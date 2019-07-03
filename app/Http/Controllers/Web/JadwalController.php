<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show all jadwal kedatangan
     * @param Date date
     * @return View jadwalKedatangan
     */
    public function showJadwalKedatangan(Request $request){
        $waktu = $request->input('waktu') ?? date('Y-m-d');
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'datang')
                                  ->whereDate('waktu', $waktu)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        return view('jadwal.kedatangan', compact('paginatedJadwal'));
    }

    /**
     * Show all jadwal keberangkatan
     * @param Date date
     * @return View jadwalKeberangkatan
     */
    public function showJadwalKeberangkatan(Request $request){
        $waktu = $request->input('waktu') ?? date('Y-m-d');
        $paginatedJadwal = Jadwal::with('kapal')
                                  ->where('status_kegiatan', 'berangkat')
                                  ->whereDate('waktu', $waktu)
                                  ->orderBy('waktu', 'asc')
                                  ->paginate(10);
        return view('jadwal.keberangkatan', compact('paginatedJadwal'));
    }

    /**
     * Show create form
     * @return View createJadwal
     */
    public function create(Request $request){
        $agenPelayaranCollection = AgenPelayaran::all();
        return view('jadwal.create', compact('agenPelayaranCollection'));
    }
}
