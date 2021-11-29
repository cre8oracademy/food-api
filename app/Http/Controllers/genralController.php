<?php

namespace App\Http\Controllers;
use App\Models\products;
use App\Models\report;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class genralController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api',['only' => ['report']]);
    }
    public function search(Request $request, $query = ""){
        $rules = array(
            $query => "nullable",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            //  products::where("product_category_item_name","like","%".$query."%")::where('active','=',true)->paginate(15);
                  $searched = DB::table('product_category_item')
                            ->where("product_category_item_name","like","%".$query."%")
                            ->orwhere("product_category_item_description","like","%".$query."%")
                            ->Where('active', 1)
                            ->paginate(15);

                return $searched;
        }
    }
    public function report(Request $request){
        $rules = array(
            "username" => "required|exists:users,username|min:5",
            "message" => "required|min:15",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
                $user_id = DB::table('users')->where('username',$valid->validated()['username'])->pluck('id');
                $report = new report;
                $report->repoted_user = $user_id[0];
                $report->created_by = $request->user()->id;
                $report->report_comment = $valid->validated()['message'];
                $report->save();
                return response()->json(['message'=>'repoted']);
        }
    }
}
