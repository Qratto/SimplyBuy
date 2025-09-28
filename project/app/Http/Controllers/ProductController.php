<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function showProducts(Request $request){
        $products_list = DB::table('products')->select('id', 'name', 'price', 'description')->get();
        return response()->json([
            'data' => $products_list            

        ],200);
    }
}
