<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Errors extends Controller
{
    //
    public function errors(){
        return response()->json(['error'=>'You are Unauthanticated']);
    }
}
