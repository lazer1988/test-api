<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Voucher;

class VoucherController extends Controller
{
    /**
     * get all active Vouchers
     * @return Voucher[]
     */
    public function index(){
        return response()->json([
            'success' => true,
            'vouchers' => Voucher::where('is_active', '=', true)->get()
        ]);
    }

    /**
     * create new voucher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $name = Input::get('name');
        $discount_id = Input::get('discount_id');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        $voucher = new Voucher();

        $voucher->timestamps = false;
        $voucher->name = $name;
        $voucher->discount_id = $discount_id;
        $voucher->start_date = $start_date;
        $voucher->end_date = $end_date;

        if(!$voucher->validate()){
            $r = false;
        }else{
            $r = $voucher->save();
        }

        $response = array(
            'success' => $r,
        );

        if($r){
            $response['voucher'] = $voucher;
        }else{
            $response['errors'] = $voucher->errors();
        }

        return response()->json($response);
    }
}
