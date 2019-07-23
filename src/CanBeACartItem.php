<?php
namespace YHShanto\ShebaCart;

use Illuminate\Database\Eloquent\Model;

class CanBeACartItem
{
    public function carts()

    {

        /** @var Model $this */
        return $this->morphMany(CartItem::class, 'product');

    }
}
