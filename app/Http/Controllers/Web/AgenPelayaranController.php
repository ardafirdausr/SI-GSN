<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Models\AgenPelayaran;
use App\Models\LogAktivitas;

class AgenPelayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int size
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $size = $request->input('size');
        $paginatedAgenPelayaran = AgenPelayaran::paginate($size);
        $topFiveAgenPelayaranLogs = LogAktivitas::where('log_type', 'App\Models\AgenPelayaran')
                                               ->orderBy('created_at', 'desc')
                                               ->get();
        return view('agen-pelayaran.index', compact('paginatedAgenPelayaran', 'topFiveAgenPelayaranLogs'));
    }

    /**
     * Create new agen_pelayaran
     * @param string nama
     * @param Image logo
     * @param string alamat
     * @param string telepon
     * @param string loket
     * @return AgenPelayaran agenPelayaran
     */
    public function store(Request $request){
        $requestData = $request->only([
            'nama',
            'logo',
            'alamat',
            'telepon',
            'loket'
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string|max:50',
            'logo' => 'sometimes|mimes:jpeg,jpg,png|max:2048',
            'alamat' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'loket' => 'required|string|unique:agen_pelayaran,loket',
        ]);
        if($validator->passes()){
            try{
                $agenPelayaran = AgenPelayaran::create($requestData);
                return redirect()->route('web.agen-pelayaran.index')
                                 ->with(['successMessage' => "Berhasil menambahkan $agenPelayaran->nama"]);
            } catch (Exception $e){
                return redirect()->route('web.agen-pelayaran.index')
                                 ->with(['errorMessage' => 'Server Error']);
            }
        }
        return redirect()->route('web.agen-pelayaran.index')
                         ->with(['errorMessage' => 'Server Error'])
                         ->withErrors($validator);
    }

    /**
     * Update agen_pelayaran by Id
     * @param string nama
     * @param Image logo
     * @param string alamat
     * @param string telepon
     * @param string loket
     * @return AgenPelayaran agenPelayaran
     */
    public function update(Request $request, AgenPelayaran $agenPelayaran){
        $requestData = $request->only([
            'nama',
            'logo',
            'alamat',
            'telepon',
            'loket',
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string|max:50',
            'logo' => 'sometimes|mimes:jpeg,jpg,png|max:2048',
            'alamat' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'loket' => 'required|string|unique:agen_pelayaran,loket',
        ]);
        if($validator->passes()){
            $isAgenPelayaranUpdated = $agenPelayaran->update($requestData);
            if($isAgenPelayaranUpdated){
                try{
                    $agenPelayaran = AgenPelayaran::find($agenPelayaran->id);
                    return redirect()->route('web.agen-pelayaran.index')
                                     ->with(['successMessage' => "Berhasil mengupdate $agenPelayaran->nama"]);
                } catch(Exception $e){
                    return redirect()->route('web.agen-pelayaran.index')
                                     ->with(['errorMessage' => 'Server Error']);
                }

            }
            return redirect()->route('web.agen-pelayaran.index')
                             ->with(['errorMessage' => 'Update Gagal']);
        }
        return redirect()->route('web.agen-pelayaran.index')
                         ->with(['errorMessage' => 'Server Error'])
                         ->withErrors($validator);
    }

    /**
     * Delete agen_pelayaran by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, AgenPelayaran $agenPelayaran){
        try{
            $namaAgenPelayaran = $agenPelayaran->nama;
            $isAgenPelayaranDeleted = $agenPelayaran->delete();
            if($isAgenPelayaranDeleted){
                return redirect()->route('web.agen-pelayaran.index')
                                 ->with(['successMessage' => "Berhasil Menghapus $namaAgenPelayaran"]);
            }
            return redirect()->route('web.agen-pelayaran.index')
                             ->with(['errorMessage' => "Gagal Menghapus $namaAgenPelayaran"]);
        } catch(Exception $e){
            return redirect()->route('web.agen-pelayaran.index')
                             ->with(['errorMessage' => 'Server Error']);
        }

    }
}
