<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Rule;
use Hash;
use Storage;

use App\Models\LogAktivitas;
use App\Models\User;

class UserController extends Controller
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
    public function index(Request $request){
        $size = $request->input('size') ?? 10;
        $key = $request->input('key') ?? 'nama';
        $query = $request->has('query')
                    ? $request->input('query')
                        ? "%{$request->input('query')}%"
                        : ''
                    : '%%';
        $paginatedUser = User::where($key, 'like', $query)
                             ->paginate($size);
        // return response()->json($paginatedUser);
        $topFiveUserLogs = LogAktivitas::where('log_type', 'App\Models\User')
                                       ->orderBy('created_at', 'desc')
                                       ->take(5)
                                       ->get();
        return view('user.index', compact('paginatedUser', 'topFiveUserLogs'));
    }

    /**
     *
     */
    public function showProfile(Request $request){
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $requestData = $request->only([
            'nama',
            'NIP',
            'username',
            'password',
            'password_confirmation',
            'access_role',
            'foto'
        ]);
        // return response()->json($requestData);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string|max:50',
            'NIP' => "required|string|max:25|unique:users,NIP",
            'username' => "required|string|max:25|unique:users,username",
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required_with:password',
            'access_role' => Rule::in('petugas terminal', 'petugas agen', 'admin'),
            'foto' =>'sometimes|file|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        // return response()->json($requestData);
        if($validator->passes()){
            try{
                $requestData['password'] = Hash::make($requestData['password']);
                $user = User::create($requestData);
                $isImageUpdated = true;
                if($request->hasFile('foto')){
                    $imageUploaded = $request->file('foto');
                    $extension = $imageUploaded->extension();
                    $folderName = '/images/user';
                    $filename = base64_encode("user#$user->id").'.'.$extension;
                    $savedImage = Storage::disk('public')->putFileAs($folderName, $imageUploaded, $filename);
                    $isImageUpdated = $user->update(['foto' => '/storage'.$folderName.'/'.$filename]);
                }
                if($user && $isImageUpdated){
                    return redirect()->route('web.user.index')
                                     ->with(['successMessage' => "Berhasil membuat $user->nama"]);
                }
                return redirect()->back()
                             ->withInput()
                             ->with([
                                 'errorMessage' => 'Update membuat user baru',
                                 'failedCreate' => true
                               ]);
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
                        ->withInput()
                        ->with([
                            'errorMessage' => 'Data tidak valid',
                            'failedCreate' => true
                        ])
                        ->withErrors($validator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user){
        $requestData = $request->only([
            'nama',
            'NIP',
            'username',
            'password',
            'password_confirmation',
            'access_role',
            'foto'
        ]);
        $validator = Validator::make($requestData, [
            'nama' => 'required|string|max:50',
            'NIP' => "sometimes|string|max:25|unique:users,NIP,$user->id",
            'username' => "sometimes|string|max:25|unique:users,username,$user->id",
            'password' => 'nullable|string|confirmed',
            'password_confirmation' => 'required_with:password',
            'access_role' => Rule::in('petugas terminal', 'petugas agen', 'admin'),
            'foto' =>'sometimes|file|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if($validator->passes()){
            try{
                if($requestData['password']){
                    $requestData['password'] = Hash::make($requestData['password']);
                }
                $requestData = array_filter($requestData, function($value){ return !!$value; });
                $isUserUpdated = $user->update($requestData);
                $isImageUpdated = true;
                if($request->hasFile('foto')){
                    $imageUploaded = $request->file('foto');
                    $extension = $imageUploaded->extension();
                    $folderName = '/images/user';
                    $filename = base64_encode("user#$user->id").'.'.$extension;
                    $savedImage = Storage::disk('public')->putFileAs($folderName, $imageUploaded, $filename);
                    $isImageUpdated = $user->update(['foto' => '/storage'.$folderName.'/'.$filename]);
                }
                if($isUserUpdated && $isImageUpdated){
                    $user = User::find($user->id);
                    return redirect()->back()
                                     ->with(['successMessage' => "Berhasil mengupdate $user->nama"]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        try{
            $namaUser = $user->nama;
            $isUserDeleted = $user->delete();
            if($isUserDeleted){
                return redirect()->back()
                                 ->with(['successMessage' => "Berhasil menghapus $namaUser"]);
            }
            return redirect()->back()
                             ->with(['errorMessage' => "Gagal menghapus $namaUser"]);
        } catch(Exception $e){
            return redirect()->back()
                             ->with(['errorMessage' => 'Server Error']);
        }

    }
}
