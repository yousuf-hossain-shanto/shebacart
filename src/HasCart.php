<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasCart
{
    public function carts()

    {

        /** @var $this Model */
        return $this->morphMany(CartItem::class, 'user');

    }

    /**
     * @param $name
     * @param $arguments
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany|HasCart
     */
    public function __call($name, $arguments)
    {
        if ($name == 'getCart') {
            return $this->carts()->where('cart_type', 'cart');
        } elseif (preg_match('/get([\w\d]+)Cart/', $name, $cart_type)) {
            $cart_type = Str::snake($cart_type[1]);
            return $this->carts()->where('cart_type', $cart_type);
        } else {
            /** @var parent Model */
            return parent::__call($name, $arguments);
        }
    }
}
