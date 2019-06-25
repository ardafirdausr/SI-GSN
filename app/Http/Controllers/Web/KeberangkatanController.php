<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeberangkatanController extends Controller{

    public function index(){
        return view('keberangkatan.index');
    }
}
