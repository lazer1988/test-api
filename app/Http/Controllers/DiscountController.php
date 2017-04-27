<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * @return Discount[]
     */
    public function index(){
        return response()->json([
            'success' => true,
            'discounts' => Discount::all()
        ]);
    }
}
