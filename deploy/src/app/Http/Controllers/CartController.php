<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addProduct(Request $request,$id){

        $product = DB::table('products')->where('id',$id)->first();

        $user = $request->user();
        if(!$product){
            return response()->json([
                'message' => 'Product not found'
            ],404);
        }

        DB::table('card')->insert([
            'user_id' => $user->id,
            'product_id' => $id,
        ]);

        return response()->json([
            'message' => 'Product add to card',
        ], 201);
    }
    public function showCart(Request $request) {
        $user = $request->user();

        $data = DB::table('card')->where('user_id', $user->id)
        ->join('products', 'card.product_id', '=', 'products.id')
        ->select('card.id','product_id','products.name', 'products.description','products.price',)->get();
        
        return response()->json([
            'data' => $data,
        ],200);
        
    }

    public function deleteProduct(Request $request,$id){
        $user = $request->user();

        DB::table('card')->where('id', $id)->where('user_id', $user->id)->delete();

        return response()->json([
            'message' => 'Item removed from cart'
        ],200);
    }
    
    public function editProfile(Request $request){
        $user = $request->user();
    
        $validator = Validator::make($request->all(), [
            "fio" => 'sometimes|string|max:255',
            "email" => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'sometimes|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'field' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();
        
        if (empty($validatedData)) {
            return response()->json([
                'message' => 'Not found field'
            ], 404);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'data updated successfully',
            
        ], 200);
    }
}
