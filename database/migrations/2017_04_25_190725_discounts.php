<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Discount;

class Discounts extends Migration
{
    private $discounts = [10,15,20,25];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('discount')->unsigned();
        });

        // fill table
        foreach ($this->discounts as $discount){
            $d = new Discount();
            $d->timestamps = false;
            $d->discount = $discount;
            $d->save();
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
