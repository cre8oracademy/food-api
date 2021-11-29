<?php

namespace App\Http\Controllers;

use App\Models\ingredients;
use App\Models\productCatagory;
use App\Models\productimages;
use App\Models\products;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Mockery\Generator\StringManipulation\Pass\Pass;
use phpDocumentor\Reflection\Types\Null_;
function check_product($Product_id){
    $exist = DB::table('product_category_item')
    ->where('product_category_item_id',$Product_id)->exists();
    if($exist){
        return true;
    }
    return false;
}
class productController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['get_single_product']]);
    }
    public function create(Request $request)
    {
        $rules = array(
            "name" => "required|min:5|max:50",
            "discription" => "required|min:20|max:500",
            "price" => "required|numeric|min:20",
            "category" => "required|exists:product_category,category_name",
            "image1" => "required|mimes:jpg,bmp,png,jpeg",
            "image2" => "nullable|mimes:jpg,bmp,png,jpeg",
            "image3" => "nullable|mimes:jpg,bmp,png,jpeg",
            "image4" => "nullable|mimes:jpg,bmp,png,jpeg",
            "image5" => "nullable|mimes:jpg,bmp,png,jpeg",
            "ingredients" => "required|array|min:2|max:500",
            "alergic_to" => "nullable|array|min:1"
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $id = null;
            $product_catagory_id = productCatagory::where('category_name','=', $valid->validated()['category'])->pluck('product_category_id');
            //return $product_catagory_id;
            
            $product_uid= Str::orderedUuid();
            $catagory = new products;
            $catagory->product_category_item_name = $valid->validated()['name'];
            $catagory->product_category_item_description = $valid->validated()['discription'];
            $catagory->product_category_item_price = $valid->validated()['price'];
            $catagory->added_by = $request->user()->id;
            $catagory->product_uid = $product_uid;
            $catagory->is_allergic =json_encode($valid->validated()['alergic_to']) ?? "Not Alergic";
            $catagory->product_category_id = $product_catagory_id[0];
            $catagory->save();
            $product_id = DB::table('product_category_item')->where('product_uid',$product_uid)->pluck('product_category_item_id');
            $image1 = $valid->validated()["image1"]->store('product_pics');
            $image2 = $valid->validated()["image2"] ?? null;
            $image3 = $valid->validated()["image3"] ?? null;
            $image4 = $valid->validated()["image4"] ?? null;
            $image5 = $valid->validated()["image5"] ?? null;


          if ($image2 != null){
          $image2 = $valid->validated()["image2"]->store('product_pics');
            }
            if ($image3 != null){
            $image3 = $valid->validated()["image3"]->store('product_pics');
            }
            if ($image4 != null){
              $image4 = $valid->validated()["image4"]->store('product_pics');
            }
            if ($image5 != null){
              $image5 = $valid->validated()["image5"]->store('product_pics');
            }
             DB::table('product_images')
                ->insert(
                    ["image1" => $image1 ?? "default.png",
                    "for_product" => $product_id[0],
                    "created_by" => $request->User()->id,
                    "image2" => $image2 ?? "default.png",
                    "image3" => $image3 ?? "default.png",
                    "image4" => $image4 ?? "default.png",
                    "image5" => $image5 ?? "default.png",]
            );
            DB::table('product_ingridents')
                ->insert(
                    ["for_product" => $product_id[0],
                    "created_by" => $request->User()->id,
                    "ingredients" =>json_encode($valid->validated()['ingredients']) ?? "Empty",]
            );
            return response()->json(['seccuss'=>true,'message' => "Opration Secussfull"]);
        }
    }
    public function update(Request $request)
    {
        $rules = array(
            "name" => "nullable|min:5|max:50",
            "product_id" => "required|numeric",
            "discription" => "nullable|min:20|max:500",
            "price" => "nullable|numeric|min:20",
            "catagory" => "nullable|min:1",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $product_catagory_id = productCatagory::where('category_name', $request->catagory)->get('category_id');
            foreach ($product_catagory_id as $id); {
                $catagory_id = $id['category_id'];
            }
            $product = DB::table('product_category_item')
                ->where('product_category_item_id', $valid->validated()['product_id'])
                ->update([
                    'product_category_item_name' => $valid->validated()['name'],
                    'product_category_item_description' => $valid->validated()['discription'],
                    'product_category_item_price' => $valid->validated()['price'],
                    'added_by' => $request->user()->id,
                    'product_category_id' => $catagory_id,

                ]);
            return response()->json(['message' => "Opration Secussfull"]);
        }
    }
    // public function upload_images(Request $request){
    //     $rules = array(
    //         "product_id" => "required|exists:product_category_item,product_category_item_id",
    //     );
    //     $valid = Validator::make($request->all(), $rules);
    //     if ($valid->fails()) {
    //         return response()->json(['error' => $valid->errors()], 401);
    //     } else {
    //         if (DB::table('product_category_item')->where('product_category_item_id',$valid->validated()['product_id'])->pluck('added_by')[0]==$request->user()->id){
    //         for ($i=1;$i<=5;$i++){

    //             try{
    //             if($valid->validated()["image".''.$i] != Null){
    //             $image = $valid->validated()["image".''.$i]->store('product_pics');
    //             $images= $image;
    //             }
    //             DB::table('product_images')
    //             ->where('for_product',$valid->validated()['product_id'])
    //             ->update(["image{$i}" => $image]);
    //         }catch(Exception $e){
    //             $ok=1;
    //         }
    //     }

    //         return response()->json(['message' => "Profile Updated"]);
    //     }
    //     else{
    //         return response()->json(['error' => "Unauthorized"],402);

    //     }

    //         //DB::table('profiles')
    //         //->where('user_id',$request->user()->id)
    //         //->update(['profile_pic'=>$profile]);

    //     }

    // }
    public function get_images(Request $request){
        $rules = array(
            "product_id" => "required|exists:product_category_item,product_category_item_id",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            return DB::table('product_images')->where('for_product',$valid->validated()['product_id'])->get();
        }
    }
    public function delete(Request $request,$product_id)
    {
        $varify = check_product($product_id);

        if ($varify == false) {
            return response()->json(['error' => "Invalid Username","success"=>false], 401);
        }else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$product_id)
            ->pluck('added_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"]);
            }
        $user_id = Db::table('product_category_item')
                    ->where('product_category_item_id',$product_id)
                    ->delete();
        return response()->json(['message'=>'Done']);

        }
    }
    public function get_product(Request $request)
    {
        $active = DB::table('product_category_item')
                    ->where('added_by', $request->user()->id)
                    ->join('product_images', 'product_category_item.added_by', '=', 'product_images.created_by')
                    ->Where('active', 1)
                    ->get();
        $unactive = DB::table('product_category_item')
                    ->where('added_by', $request->user()->id)
                    ->join('product_images', 'product_category_item.added_by', '=', 'product_images.created_by')
                    ->Where('active', 0)
                    ->get();
        return response()->json(['active' => $active,'Not Active' => $unactive], 200);

    }
    public function get_single_product(Request $request,$product_uid="null")
    {
        $active = DB::table('product_category_item')
                    ->where('product_uid', $product_uid)
                    ->join('product_images', 'product_category_item.product_category_item_id', '=', 'product_images.for_product')
                    ->Where('active', 1)
                    ->get();
        return response()->json(['active' => $active], 200);
    }
    public function add_ingredients(Request $request){
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
            "ingredients" => "required|min:2|max:500",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('created_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"]);
            }
            $ingr = new ingredients;
            $ingr->for_product=$valid->validated()['product_id'];
            $ingr->ingredients=json_encode($valid->validated()['ingredients']);
            $ingr->created_by=$request->user()->id;
            $ingr->save();
            return response()->json(['message' => "Opration Secussfull"]);
        }
    }
    public function get_ingredients(Request $request){
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('created_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"],302);
            }
            $enabled = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('list_ingredients');
            if ($enabled[0] != 0 ){
                $ingredients = DB::table('product_ingridents')
                        ->where('for_product',$valid->validated()['product_id'])
                        ->get();
                return $ingredients;
            }
            return response()->json(['message' => "Ingredients are private for this product"]);
        }
    }
    public function activate_switch(Request $request)
    {
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
            "switch" => "boolean|required"
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $affected = DB::table('product_category_item')
                ->where('product_category_item_id', $valid->validated()['product_id'])
                ->update(['active' => $valid->validated()['switch']]);
        if ( $valid->validated()['switch'] == 1){
                return response()->json(['message' => "Activation Secussfull"]);
        }else{
            return response()->json(['message' => "Deactivated"]);
        }
        }
    }
    public function alergic(Request $request)
    {
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
            "alergic_to" => "nullable|min:5"
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('added_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"]);
            }
        $affected =DB::table('product_category_item')
        ->where('product_category_item_id', $valid->validated()['product_id'])
        ->update(['is_allergic' => $valid->validated()['product_id']] ?? "Nothing" );

        return response()->json(['message' => "Opration Secussfull"]);
        }
    }
    public function custum_order(Request $request)
    {
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('added_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"]);
            }
        $affected = DB::table('product_category_item')
            ->where('product_category_item_id', $valid->validated()['product_id'])
            ->update(['custom_order' => 1]);
        return response()->json(['message' => "User now can make custom ordder"]);
        }
    }
    public function custum_order_disable(Request $request)
    {
        $rules = array(
            "product_id" => "required|numeric|exists:product_category_item,product_category_item_id",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $yours = DB::table('product_category_item')
            ->where('product_category_item_id',$valid->validated()['product_id'])
            ->pluck('added_by');
            if ($yours[0] != $request->user()->id){
                return response()->json(['error' => "Un-authorised"]);
            }
        $affected = DB::table('product_category_item')
            ->where('product_category_item_id', $valid->validated()['product_id'])
            ->update(['custom_order' => 0]);
        return response()->json(['message' => "User now cannot make custom ordder"]);
        }
    }
    protected function guard()
    {
        return Auth::guard();
    }
}
