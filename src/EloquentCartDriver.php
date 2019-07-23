<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;
use YHShanto\ShebaCart\Contracts\CartDriver;

class EloquentCartDriver implements CartDriver
{
    protected $cart_type;
    protected $auth;

    public function __construct($cart_type, HasCart $auth)

    {
        $this->cart_type = $cart_type;
        $this->auth = $auth;
    }

    /**
     * @param $product_id
     * @param int $quantity
     * @param $price
     * @param array $options
     * @return CartInstance
     */
    function add($product_id, $quantity = 1, $price, $options = [])
    {
        // TODO: Implement add() method.
    }

    /**
     * @param $product_id
     * @param array $options
     * @return CartInstance
     */
    function update($product_id, $options = [])
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $product_id
     * @return CartInstance
     */
    function remove($product_id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $product_id
     * @return Model
     */
    function get($product_id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @return CartInstance
     */
    function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * @return boolean
     */
    function destroy()
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param null $prefix
     * @param bool $formatted
     * @return mixed
     */
    function total($prefix = null, $formatted = false)
    {
        // TODO: Implement total() method.
    }

    /**
     * @return integer
     */
    function count()
    {
        // TODO: Implement count() method.
    }
}
