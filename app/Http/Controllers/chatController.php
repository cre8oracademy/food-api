<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\orderDetails;
use App\Models\productCatagory;
use App\Models\chat;
use App\Models\products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class chatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function send(Request $request){
        $rules = array(
            "message" => "required|min:1",  
            "for" => "required|exists:users,username",  
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
        $user = Db::table('users')
                ->where('username', $valid->validated()['for'])
                ->pluck('id');
        $massege = new chat;
        $massege->message = $valid->validated()['message'];
        $massege->created_for = $user[0];
        $massege->created_by =  $request->user()->id;
        $massege->save();
        return response()->json(['message' => "sent"]);
        }
    }
    public function recive(Request $request){
        $message = Db::table('chat_app')
                ->where('created_for',  $request->user()->id)
                ->get();
        return response()->json($message);
    }
    protected function guard()
    {
        return Auth::guard();
    }
}
