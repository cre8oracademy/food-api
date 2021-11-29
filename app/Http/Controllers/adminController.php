<?php

namespace App\Http\Controllers;

use App\Models\productCatagory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

function check_username($username)
{
    $exist = DB::table('users')
        ->where('username', $username)->exists();
    if ($exist) {
        return true;
    }
    return false;
}
class adminController extends Controller
{
    //
    public function __construct()
    {
        $roles = ['admin'];
        $this->middleware("auth.role:admin");
    }

    public function reports(Request $request)
    {
        $reports = Db::table('reports')
            ->get();
        return response()->json($reports);
    }
    public function delete_user(Request $request, $username)
    {
        $varify = check_username($username);

        if ($varify == false) {
            return response()->json(['error' => "Invalid Username", "success" => false], 401);
        } else {
            $user_id = Db::table('users')
                ->where('username', $username)
                ->pluck('id');
            //return $user_id;
            $res =  DB::table('profiles')->where('user_id', '=', $user_id[0])->delete() &&  DB::table('users')->where('id', '=', $user_id[0])->delete();
            if (!$res) {
                return response()->json(['message' => 'Error', "success" => false], 500);
            }
            //$user_id->delete();
            return response()->json(['message' => 'User Deleted', "success" => true], 200);
        }
    }

    public function create_catagory(Request $request)
    {
        $rules = array(
            "name" => "required",
            "discription" => "nullable|min:20",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors(), "success" => false], 401);
        } else {
            $catagory = new productCatagory;
            $catagory->category_name = $valid->validated()['name'];
            $catagory->category_description = $valid->validated()['discription'];
            $catagory->added_by = $request->user()->id;
            $catagory->shop_id = $request->user()->id;
            $catagory->save();
            return response()->json(['message' => "Opration Secussfull", "success" => true]);
        }
    }
    public function cancel_order(Request $request)
    {
        $rules = array(
            "order_uid" => "required|exists:order_t,order_uid",

        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors(), "success" => false], 401);
        } else {
            DB::table('order_t')
                ->where('order_uid', $valid->validated()['order_uid'])
                ->update(['canceled' => 1, 'active' => 0]);
            return response()->json(['message' => "Order canceled by admin", "success" => true]);
        }
    }
    public function total_users(Request $request)
    {
        return DB::table('users')->count();
    }
    public function orders(Request $request)
    {
        $orders = DB::table('order_t')->get();
        foreach ($orders as $order) {
            $order->details = DB::table('order_details')->where('order_id', $order->order_id)->get();
            $order->items = DB::table('order_items')->where('order_id', $order->order_id)->get();
        }
        return response()->json($orders);
    }
}