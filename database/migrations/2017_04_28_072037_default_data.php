<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Voucher;
use App\Product;

class DefaultData extends Migration
{

    private $vouchers = array(
        array(
            'discount_id' => 1,
            'name' => 'voucher for 10%',
            'start_date' => '2017-04-20',
            'end_date' => '2017-06-15',
        ),
        array(
            'discount_id' => 2,
            'name' => 'voucher for 15%',
            'start_date' => '2017-04-23',
            'end_date' => '2017-05-15',
        ),
        array(
            'discount_id' => 3,
            'name' => 'voucher for 20%',
            'start_date' => '2017-03-23',
            'end_date' => '2017-04-30',
        ),
        array(
            'discount_id' => 4,
            'name' => 'voucher for 25%',
            'start_date' => '2017-04-30',
            'end_date' => '2017-07-15',
        ),
    );

    private $products = array(
        array(
            'name' => 'prod 1',
            'price' => 10,
            'vouchers' => [1,2]
        ),
        array(
            'name' => 'prod 2',
            'price' => 15,
            'vouchers' => [3]
        ),
        array(
            'name' => 'prod 3',
            'price' => 20,
            'vouchers' => []
        ),
        array(
            'name' => 'prod 4',
            'price' => 50,
            'vouchers' => [1,2,3,4]
        ),
        array(
            'name' => 'prod 1',
            'price' => 40,
            'vouchers' => [1,3]
        ),
    );

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create vouchers
        foreach ($this->vouchers as $voucher){
            $v = new Voucher();

            $v->timestamps = false;
            $v->discount_id = $voucher['discount_id'];
            $v->name = $voucher['name'];
            $v->start_date = $voucher['start_date'];
            $v->end_date = $voucher['end_date'];

            $v->save();
        }

        // create products
        foreach ($this->products as $product){
            $p = new Product();

            $p->name = $product['name'];
            $p->price = $product['price'];

            $p->save();

            $p->vouchers()->attach($product['vouchers']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
