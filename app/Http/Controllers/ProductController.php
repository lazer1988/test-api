<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Product;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller
{
    /**
     * get all products with sorting by name
     * @return Product[]
     */
    public function index(){
        $sort = Input::get('sort','ASC');

        return response()->json([
            'success' => true,
            'products' => Product::orderBy('name', $sort)->get()
        ]);
    }

    /**
     * Create a new product
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $name = Input::get('name');
        $price = Input::get('price');
        $vouchers = Input::get('vouchers');

        $errors = array();

        // save with transaction
        DB::beginTransaction();

        try{
            // create new product
            $product = new Product();
            $product->name = $name;
            $product->price = $price;

            if($product->validate()){
                $product->save();

                // attach vouchers to product
                $product->vouchers()->attach($vouchers);

                $result = true;

                DB::commit();
            }else{
                $result = false;
                $errors = $product->errors();
                DB::rollBack();
            }
        }catch (Exception $e){
            $result = false;
            DB::rollBack();
        }

        $response = array(
            'success' => $result,
        );

        if($result){
            $response['product'] = $product;
        }else{
            $response['errors'] = $errors;
        }

        return response()->json($response);
    }

    /**
     * Buy product
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(){
        $product_id = Input::get('id');
        $product = Product::find($product_id);
        if(!$product){
            return response()->json([
                'success' => false,
                'error' => 'product does not exist'
            ]);
        }

        if($product->is_bought){
            return response()->json([
                'success' => false,
                'error' => 'Product already purchased'
            ]);
        }

        // save with transaction
        DB::beginTransaction();
        try{
            $product->is_bought = true;
            $product->save();

            // mark vouchers as inactive (used)
            foreach ($product->actualVouchers as $voucher){
                $voucher->timestamps = false;
                $voucher->is_active = false;
                $voucher->save();
            }

            $result = true;

            DB::commit();
        }catch (Exception $e){
            $result = false;
            DB::rollBack();
        }

        return response()->json([
            'success' => $result
        ]);
    }
}
