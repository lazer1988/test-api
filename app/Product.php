<?php

namespace App;

class Product extends BaseModel
{
    private $_maxDiscount = 60;

    protected $attributes = [
        'is_bought' => false
    ];

    protected $appends = ['discount_price','discount'];

    protected $rules = array(
        'name' => 'required|max:100',
        'price' => 'required|numeric',
    );

    /**
     * vouchers relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function vouchers(){
        return $this->belongsToMany('App\Voucher','product2voucher');
    }

    /**
     * Get actual vouchers that did not use
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function actualVouchers(){
        return $this->vouchers()->where('is_active', '=', true)
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'));
    }

    /**
     * Calc new price with discount
     * @return float
     */
    function getDiscountPriceAttribute(){
        if($this->discount > 0){
            return $this->price - ($this->price*$this->discount/100);
        }

        return $this->price;
    }

    /**
     * Calc discount for product
     * @return int
     */
    function getDiscountAttribute(){
        $discount = 0;
        foreach ($this->actualVouchers as $voucher){
            $discount += $voucher->discount->discount;
        }

        if($discount > $this->_maxDiscount)
            return $this->_maxDiscount;
        return $discount;
    }

    public function toArray()
    {
        $data = parent::toArray();

        $data['vouchers'] = [];
        foreach ($this->vouchers as $voucher){
            $data['vouchers'][] = $voucher->toArray();
        }

        return $data;
    }
}
