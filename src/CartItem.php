<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_datas';
    protected $guarded = ['id'];
    protected $casts = [
        'options' => 'array'
    ];

    public function user()

    {

        return $this->morphTo();

    }

    public function product()

    {

        return $this->morphTo();

    }
}
