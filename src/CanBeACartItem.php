<?php
namespace YHShanto\ShebaCart;

use Illuminate\Database\Eloquent\Model;

trait CanBeACartItem
{

    public function getProductTypeAttribute()

    {

        return get_class($this);

    }

    public function carts()

    {

        /** @var Model $this */
        return $this->morphMany(CartItem::class, 'product');

    }
}
