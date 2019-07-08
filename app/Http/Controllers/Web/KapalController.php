<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Kapal;

class KapalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $size = $request->input('size') ?? 10;
        $paginatedKapal = Kapal::with('agen_pelayaran')->paginate($size);
        return view('kapal.index', compact('paginatedKapal'));
    }

    /**
     * Create new kapal
     * @param string kode
     * @param string nama
     * @param int id_agen_pelayaran
     * @return Kapal kapal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'kode',
            'nama',
            'id_agen_pelayaran'
        ]);
        $validator = Validator::make($requestData, [
            'kode' => 'required|string|unique:kapal',
            'nama' => 'required|string',
            'id_agen_pelayaran' => 'required|integer|exists:agen_pelayaran,id'
        ]);
        if($validator->passes()){
            $kapal = Kapal::create($requestData);
            return redirect()->route('web.kapal.index')
                             ->with(['successMessage' => "Berhasil menambahkan $kapal->nama"]);
        }
        return redirect()->route('web.kapal.index')
                         ->with(['errorMessage' => 'Data tidak valid'])
                         ->withErrors($validator);
    }

    /**
     * Update kapal by Id
     * @param string kode
     * @param string nama
     * @param int id_agen_pelayaran
     * @return Kapal kapal
     */
    public function update(Request $request, Kapal $kapal){
        $isKodeIdentic = $kapal->kode == $request->input('kode');
        $requestData = null;
        if($isKodeIdentic){
            $requestData = $request->only(['nama', 'id_agen_pelayaran']);
            $validator = Validator::make($requestData, [
                'nama' => 'required|string',
                'id_agen_pelayaran' => 'required|integer|exists:agen_pelayaran,id'
            ]);
        }
        else{
            $requestData = $request->only([
                'kode',
                'nama',
                'id_agen_pelayaran'
            ]);
            $validator = Validator::make($requestData, [
                'kode' => 'required|string|unique:kapal',
                'nama' => 'required|string',
                'id_agen_pelayaran' => 'required|integer|exists:agen_pelayaran,id'
            ]);
        }
        if($validator->passes()){
            $isKapalUpdated = $kapal->update($requestData);
            if($isKapalUpdated){
                return redirect()->route('web.kapal.index')
                                 ->with(['successMessage' => "Berhasil mengupdate $kapal->nama"]);
            }
            return redirect()->route('web.kapal.index')
                             ->with(['errorMessage' => "Gagal mengupdate $kapal->nama"]);
        }
        return redirect()->route('web.kapal.index')
                         ->with(['errorMessage' => 'Data tidak valid'])
                         ->withErrors($validator);
    }

    /**
     * Delete kapal by Id
     * @return null
     */
    public function destroy(Request $request, Kapal $kapal){
        $kapalName = $kalap->nama;
        $isKapalDeleted = $kapal->delete();
        if($isKapalDeleted) {
            return redirect()->route('web.kapal.index')
                             ->with(['successMessage' => "Berhasil menghapus $kapalName"]);
        }
        return redirect()->route('web.kapal.index')
                         ->with(['errorMessage' => "Gagal menghapus $kapalName"]);
    }
}
