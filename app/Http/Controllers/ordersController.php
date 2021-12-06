<?php

namespace App\Http\Controllers;

use App\Models\order_items;
use App\Models\orders;
use App\Models\orderDetails;
use App\Models\productCatagory;
use App\Models\products;
use Illuminate\Support\Str;
use App\Models\craditcards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ordersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function place_order(Request $request)
    {
        //$request->product[1]['product_id'];
        $rules = array(
            "product" => "required|array",
            "product.*.product_id" => "required|exists:product_category_item,product_category_item_id",
            "product.*.amount" => "required|numeric",
            "product.*.custom" => "nullable|min:2",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $order_uid = Str::orderedUuid();
            $counter = 0;
            $Total_amount = 0;
            $total_items = 0;
            foreach ($request->product as $product) {
                $shop_id = DB::table('product_category_item')
                    ->where('product_category_item_id', $product['product_id'])
                    ->pluck('added_by');
                $custom = DB::table('product_category_item')
                    ->where('product_category_item_id', $product['product_id'])
                    ->pluck('custom_order');
                $price[$counter] = DB::table('product_category_item')
                    ->where('product_category_item_id', $product['product_id'])
                    ->pluck('product_category_item_price');
                $total_items += $product['amount'];
                $Total_amount += $product['amount'] * $price[$counter][0];
                $counter++;
            }

            $order = new orders;
            $order->order_uid = $order_uid;
            $order->created_by = $request->user()->id;
            $order->buyer_id = $request->user()->id;
            $order->active = 1;
            $order->total_products = $total_items;
            $order->total_amount = $Total_amount;
            $order->save();
            $order_id = DB::table('order_t')
                ->where('order_uid', $order_uid)
                ->pluck('order_id');
            $order_detail = new orderDetails;
            $order_detail->order_id = $order_id[0];
            $order_detail->item_price = $Total_amount;
            $order_detail->created_by = $request->user()->id;
            $order_detail->item_quantity =  $total_items;
            if ($custom[0] == 1) {
                $order_detail->custom =  $valid->validated()['custom'] ?? "no customization";
            } else {
                $order_detail->custom = "Not allowed by product owner";
            }
            $order_detail->save();



            foreach ($request->product as $product) {
                $items = new order_items;
                $items->order_id = $order_id[0];
                $items->product_id = $product['product_id'];
                $items->amount = $product['amount'];
                $items->added_by = $request->user()->id;
                $items->save();
            }
            return response()->json(['message' => "Order Placed"]);
        }
    }
    public function cancel(Request $request)
    {
        $rules = array(
            "order_uid" => "required|exists:order_t,order_uid",

        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $shop_id = DB::table('order_t')
                ->where('order_uid', $valid->validated()['order_id'])
                ->pluck('shop_id');
            if ($shop_id[0] == $request->user()->id) {
                $shop_id = DB::table('order_t')
                    ->where('order_uid', $valid->validated()['order_id'])
                    ->update(['canceled' => 1, 'active' => 0]);
                return response()->json(['message' => "Order canceled"]);
            } else {
                return response()->json(['error' => "unAuthorized"], 402);
            }
        }
    }
    public function accept(Request $request)
    {
        $rules = array(
            "order_id" => "required|exists:order_t,order_uid",

        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $shop_id = DB::table('order_t')
                ->where('order_uid', $valid->validated()['order_id'])
                ->pluck('shop_id');
            if ($shop_id[0] == $request->user()->id) {
                $shop_id = DB::table('order_t')
                    ->where('order_uid', $valid->validated()['order_id'])
                    ->update(['completed' => 1, 'active' => 0]);
                return response()->json(['message' => "Order completed"]);
            } else {
                return response()->json(['error' => "unAuthorized"], 402);
            }
        }
    }
    public function canceled(Request $request)
    {
        $canceled = DB::table('order_t')
            ->where('shop_id', $request->user()->id)
            ->where('canceled', 1)
            ->get();
        return response()->json(['canceled' => $canceled]);
    }
    public function completed(Request $request)
    {
        $completed = DB::table('order_t')
            ->where('shop_id', $request->user()->id)
            ->where('completed', 1)
            ->get();
        return response()->json(['completed' => $completed]);
    }
    public function active(Request $request)
    {
        $active = DB::table('order_t')
            ->where('shop_id', $request->user()->id)
            ->where('active', 1)
            ->get();
        return response()->json(['active' => $active]);
    }
    public function order_details(Request $request, $order_uid)
    {
        $valid = DB::table('order_t')->where('order_uid', $order_uid)->exists();

        if (!$valid) {
            return response()->json(['error' => "Invalid UID"], 404);
        } else {
            $order = DB::table('order_t')->where('order_uid', $order_uid)->get();
            $order_details = DB::table('order_details')->where('order_id', $order[0]->order_id)->get();
            $order_items = DB::table('order_items')->where('order_id', $order[0]->order_id)->get();
            return response()->json(['seccuss' => true, 'Order' => $order, 'Order Details' => $order_details, 'Order Items' => $order_items], 200);
        }
    }
    public function dilivrydetails(Request $request)
    {
        $rules = array(
            "order_uid" => "required|exists:order_t,order_uid",
            "delivery_address" => "required",
            "product_id" => "required|exists:product_category_item,product_category_item_id",
            "buyer_id" => "required|exists:users,id",
            "payment_method" => "required",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            DB::table('dilivry')->insert([
                'order_uid' => $valid->validated()['order_uid'],
                'dilivry_adress' => $valid->validated()['delivery_address'],
                'for_product' => $valid->validated()['product_id'],
                'buyer_id' => $valid->validated()['buyer_id'],
                'payment_method' => $valid->validated()['payment_method'],
            ]);
            return response()->json(['message' => "Dilivry details added"]);
        }
    }
    //cradit card get
    public function get_card(Request $request)
    {
        $rules = array(
            "user_id" => "required|exists:users,id",

        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $card = DB::table('craditcards')->where('user_id', $valid->validated()['user_id'])->get();
            return response()->json(['card' => $card]);
        }
    }
    //cradit card add
    public function add_card(Request $request)
    {
        $rules = array(
            "user_id" => "required|exists:users,id",
            "number" => "required|unique:craditcards,card_number",
            "card_name" => "required",
            "expiry_date" => "required",
            "cvv" => "required",

        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            DB::table('craditcards')->insert([
                'user_id' => $valid->validated()['user_id'],
                'name' => $valid->validated()['card_name'],
                'number' => $valid->validated()['number'],
                'expiry' => $valid->validated()['expiry_date'],
                'cvv' => $valid->validated()['cvv'],
            ]);
            return response()->json(['message' => "Card Added"]);
        }
    }

    protected function guard()
    {
        return Auth::guard();
    }
}