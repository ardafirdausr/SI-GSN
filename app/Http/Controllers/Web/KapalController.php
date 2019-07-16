<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\Kapal;
use App\Models\LogAktivitas;

class KapalController extends Controller
{

    /**
     * Set middleware for theese functions
     */
    public function __construct(){
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $size = $request->input('size') ?? 10;
        $key = $request->input('key') ?? 'nama';
        // query = '' is included
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : ''
                    : '%%';
        $paginatedKapal = Kapal::where($key, 'like', $query)
                               ->with('agen_pelayaran')
                               ->paginate($size);
        $topFiveKapalLogs = LogAktivitas::where('log_type', 'App\Models\Kapal')
                                        ->orderBy('created_at', 'desc')
                                        ->take(5)
                                        ->get();
        return view('kapal.index', compact('paginatedKapal', 'topFiveKapalLogs'));
    }

    /**
     * Create new kapal
     * @param string kode
     * @param string nama
     * @param int agen_pelayaran_id
     * @return Kapal kapal
     */
    public function store(Request $request){
        $requestData = $request->only([
            'kode',
            'nama',
            'agen_pelayaran_id'
        ]);
        $validator = Validator::make($requestData, [
            'kode' => 'required|string|unique:kapal,kode',
            'nama' => 'required|string',
            'agen_pelayaran_id' => 'required|integer|exists:agen_pelayaran,id'
        ]);
        if($validator->passes()){
            $kapal = Kapal::create($requestData);
            return redirect()->route('web.kapal.index')
                             ->with([
                                 'successMessage' => "Berhasil menambahkan $kapal->nama"
                               ]);
        }
        return redirect()->back()
                         ->with([
                             'errorMessage' => 'Data tidak valid',
                             'failedCreate' => true
                          ])
                         ->withInput()
                         ->withErrors($validator);
    }

    /**
     * Update kapal by Id
     * @param string kode
     * @param string nama
     * @param int agen_pelayaran_id
     * @return Kapal kapal
     */
    public function update(Request $request, Kapal $kapal){
        $requestData = $request->only([
            'nama',
            'kode',
            'agen_pelayaran_id'
        ]);
        $validator = Validator::make($requestData, [
            'kode' => "required|string|unique:kapal,kode,$kapal->id",
            'nama' => 'required|string',
            'agen_pelayaran_id' => 'required|integer|exists:agen_pelayaran,id'
        ]);
        if($validator->passes()){
            $isKapalUpdated = $kapal->update($requestData);
            if($isKapalUpdated){
                return redirect()->back()
                                 ->with(['successMessage' => "Berhasil mengupdate $kapal->nama"]);
            }
            return redirect()->back()
                             ->with([
                                 'errorMessage' => "Gagal mengupdate $kapal->nama",
                                 'failedUpdate' => true
                               ])
                             ->withInput();
        }
        return redirect()->back()
                         ->with([
                            'errorMessage' => 'Data tidak valid',
                            'failedUpdate' => true
                           ])
                         ->withInput()
                         ->withErrors($validator);
    }

    /**
     * Delete kapal by Id
     * @return null
     */
    public function destroy(Request $request, Kapal $kapal){
        $kapalName = $kapal->nama;
        $isKapalDeleted = $kapal->delete();
        if($isKapalDeleted) {
            return redirect()->back()
                             ->with(['successMessage' => "Berhasil menghapus $kapalName"]);
        }
        return redirect()->back()
                         ->with(['errorMessage' => "Gagal menghapus $kapalName"]);
    }
}
