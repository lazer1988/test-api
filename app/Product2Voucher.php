<?php

namespace App;

class Product2Voucher extends BaseModel
{
    protected $table = 'product2voucher';

    /**
     * product relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function product(){
        return $this->belongsTo('App\Product');
    }
}
