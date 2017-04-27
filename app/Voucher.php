<?php

namespace App;

class Voucher extends BaseModel
{

    protected $rules = array(
        'name' => 'required|max:100',
        'discount_id' => 'required|numeric',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    );

    /**
     * discount relation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    function discount(){
        return $this->hasOne('App\Discount','id','discount_id');
    }

}
