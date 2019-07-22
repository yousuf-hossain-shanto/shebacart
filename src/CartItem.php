<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_datas';

    public function user()

    {

        return $this->morphTo();

    }

    public function product()

    {

        return $this->morphTo();

    }
}
