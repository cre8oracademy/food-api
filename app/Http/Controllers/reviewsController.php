<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\orderDetails;
use App\Models\productCatagory;
use App\Models\products;
use App\Models\reviews;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class reviewsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function add(Request $request){
        $rules = array(
            "review" => "required|numeric|min:1|max:5",
            "comment" => "required|min:20|max:500",
            "order_uid" => "required|exists:order_t,order_uid",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $shop_id = DB::table('order_t')
            ->where('order_uid', $valid->validated()['order_uid'])
            ->pluck('shop_id');
            $order_id = DB::table('order_t')
            ->where('order_uid', $valid->validated()['order_uid'])
            ->pluck('order_id');
            $product_id = DB::table('order_details')
            ->where('order_id', $order_id[0])
            ->pluck('product_category_item_id');
            $review = new reviews;
            $review = new reviews;
            $review->comment = $valid->validated()['comment'];
            $review->created_by = $request->user()->id;
            $review->for_product = $product_id[0];
            $review->for_shop = $shop_id[0];
            $review->order_uid = $valid->validated()['order_uid'];
            $review->save();
            return response()->json(['message' => "review submited"]);
        }
    }
    protected function guard()
    {
        return Auth::guard();
    }
}
