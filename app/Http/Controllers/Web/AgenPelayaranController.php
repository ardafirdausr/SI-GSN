<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Storage;
use Log;

use App\Models\AgenPelayaran;
use App\Models\LogAktivitas;

class AgenPelayaranController extends Controller{

    /**
     * Set middleware for theese functions
     */
    public function __construct(){
        $this->middleware(['auth:web']);
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the resource.
     * @param int size
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $size = $request->input('size');
        $key = $request->input('key') ?? 'nama';
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : ''
                    : '%%';
        $paginatedAgenPelayaran = AgenPelayaran::where($key, 'like', $query)
                                               ->paginate($size);
        // return response()->json($paginatedAgenPelayaran);
        $topFiveAgenPelayaranLogs = LogAktivitas::where('log_type', 'App\Models\AgenPelayaran')
                                               ->orderBy('created_at', 'desc')
                                               ->take(5)
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
            'logo' => 'sometimes|file|image|mimes:jpeg,jpg,png|max:2048',
            'alamat' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'loket' => 'required|string|unique:agen_pelayaran,loket',
        ]);
        if($validator->passes()){
            try{
                $agenPelayaran = AgenPelayaran::create($requestData);
                if($request->hasFile('logo')){
                    $imageUploaded = $request->file('logo');
                    $extension = $imageUploaded->extension();
                    $folderName = '/images/agen-pelayaran';
                    $filename = base64_encode("agen-pelayaran#$agenPelayaran->id").'.'.$extension;
                    Storage::disk('public')->putFileAs($folderName, $imageUploaded, $filename);
                    $agenPelayaran->update(['logo' => '/storage'.$folderName.'/'.$filename]);
                }
                return redirect()->route('web.agen-pelayaran.index')
                                 ->with([
                                     'successMessage' => "Berhasil menambahkan $agenPelayaran->nama"
                                  ]);
            } catch (Error $e){
                return redirect()->back()
                                 ->withInput()
                                 ->with([
                                     'errorMessage' => 'Server Error',
                                     'failedCreate' => true
                                 ]);
            }
        }
        return redirect()->back()
                        ->withInput()
                        ->with([
                            'errorMessage' => 'Data tidak valid',
                            'failedCreate' => true
                        ])
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
            'logo' => 'sometimes|file|image|max:2048',
            'alamat' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'loket' => 'sometimes|string|unique:agen_pelayaran,loket,'.$agenPelayaran->id,
        ]);

        if($validator->passes()){
            try{
                $isAgenPelayaranUpdated = $agenPelayaran->update($requestData);
                $isImageUpdated = true;
                if($request->hasFile('logo')){
                    $imageUploaded = $request->file('logo');
                    $extension = $imageUploaded->extension();
                    $folderName = '/images/agen-pelayaran';
                    $filename = base64_encode("agen-pelayaran#$agenPelayaran->id").'.'.$extension;
                    $savedImage = Storage::disk('public')->putFileAs($folderName, $imageUploaded, $filename);
                    $isImageUpdated = $agenPelayaran->update(['logo' => '/storage'.$folderName.'/'.$filename]);
                }
                if($isAgenPelayaranUpdated && $isImageUpdated){
                    $agenPelayaran = AgenPelayaran::find($agenPelayaran->id);
                    return redirect()->back()
                                     ->with(['successMessage' => "Berhasil mengupdate $agenPelayaran->nama"]);
                }
                return redirect()->back()
                             ->withInput()
                             ->with([
                                 'errorMessage' => 'Update Gagal',
                                 'failedUpdate' => true
                               ]);
            } catch(Exception $e){
                    return redirect()->back()
                                     ->withInput()
                                     ->with([
                                         'errorMessage' => 'Server Error',
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
     * Delete agen_pelayaran by Id
     * @param int id
     * @return null
     */
    public function destroy(Request $request, AgenPelayaran $agenPelayaran){
        try{
            $namaAgenPelayaran = $agenPelayaran->nama;
            $isAgenPelayaranDeleted = $agenPelayaran->delete();
            if($isAgenPelayaranDeleted){
                return redirect()->back()
                                 ->with(['successMessage' => "Berhasil menghapus $namaAgenPelayaran"]);
            }
            return redirect()->back()
                             ->with(['errorMessage' => "Gagal menghapus $namaAgenPelayaran"]);
        } catch(Exception $e){
            return redirect()->back()
                             ->with(['errorMessage' => 'Server Error']);
        }

    }
}