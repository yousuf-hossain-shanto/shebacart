<?php

namespace YHShanto\ShebaCart;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use YHShanto\ShebaCart\Contracts\CartDriver;

class EloquentCartDriver implements CartDriver
{
    protected $cart_type;
    protected $guard;

    public function __construct($cart_type, $guard)

    {
        $this->cart_type = $cart_type;
        $this->guard = $guard;
    }

    /**
     * @return Model|Authenticatable|Notifiable|HasCart
     */
    public function getUser()

    {

        return $this->guard->user();

    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param int $quantity
     * @param $price
     * @param array $options
     * @param null $tax
     * @param array $config
     * @return mixed
     */
    function add($product_type = 'App\Product', $product_id, $quantity = 1, $price, $options = [], $tax = null, $config = [])
    {
        $res = $this->getUser()->carts()->create([
            'cart_type' => $this->cart_type,
            'product_type' => $product_type,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
            'tax' => $tax,
            'options' => $options,
            'config' => $config,
        ]);
        if (!$res) return $res;
        $res->setRelation('product', $res->product);

        return $res;
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param array $options
     * @param null $cart_item_id
     * @return mixed
     */
    function update($product_type = 'App\Product', $product_id, $options = [], $cart_item_id = null)
    {
        if ($cart_item_id) {
            return $this->getUser()->carts()->where('id', $cart_item_id)->update($options);
        }
        return $this->getUser()->carts()->where('product_type', $product_type)->where('product_id', $product_id)->update($options);
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function remove($product_type = 'App\Product', $product_id, $cart_item_id = null)
    {
        if ($cart_item_id) {
            return $this->getUser()->carts()->where('id', $cart_item_id)->delete();
        }
        return $this->getUser()->carts()->where('product_type', $product_type)->where('product_id', $product_id)->delete();
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function get($product_type = 'App\Product', $product_id, $cart_item_id = null)
    {
        if ($cart_item_id) {
            return $this->getUser()->carts()->where('id', $cart_item_id)->first();
        }
        return $this->getUser()->carts()->where('product_type', $product_type)->where('product_id', $product_id)->first();
    }

    /**
     * @return mixed
     */
    function all()
    {
        return $this->getUser()->carts;
    }

    /**
     * @return mixed
     */
    function destroy()
    {
        return $this->getUser()->carts()->delete();
    }

    /**
     * @param null $prefix
     * @param bool $formatted
     * @param bool $withTax
     * @return mixed
     */
    function total($prefix = null, $formatted = false, $withTax = false)
    {
        if ($withTax) {
            return $this->getUser()->carts()->selectRaw("(price+tax)*quantity as total_price")->get()->sum('total_price');
        }
        return $this->getUser()->carts()->selectRaw("price*quantity as total_price")->get()->sum('total_price');
    }

    /**
     * @param null $cart_item_id
     * @return mixed
     */
    function count($cart_item_id = null)
    {
        if ($cart_item_id) {
            return $this->getUser()->carts()->where('id', $cart_item_id)->sum('quantity');
        }
        return $this->getUser()->carts()->sum('quantity');
    }
}
