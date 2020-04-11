<?php

namespace YHShanto\ShebaCart\Contracts;

interface CartDriver
{
    /**
     * @param string $product_type
     * @param $product_id
     * @param int $quantity
     * @param $price
     * @param array $options
     * @param null|double $tax
     * @param array $config
     * @return mixed
     */
    function add($product_type = 'App\Product', $product_id, $quantity = 1, $price, $options = [], $tax = null, $config = []);

    /**
     * @param string $product_type
     * @param $product_id
     * @param array $options
     * @param null $cart_item_id
     * @return mixed
     */
    function update($product_type = 'App\Product', $product_id, $options = [], $cart_item_id = null);

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function remove($product_type = 'App\Product', $product_id, $cart_item_id = null);

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function get($product_type = 'App\Product', $product_id, $cart_item_id = null);

    /**
     * @return mixed
     */
    function all();

    /**
     * @return mixed
     */
    function destroy();

    /**
     * @param null $prefix
     * @param bool $formatted
     * @param bool $withTax
     * @return mixed
     */
    function total($prefix = null, $formatted = false, $withTax = false);

    /**
     * @param null $cart_item_id
     * @return mixed
     */
    function count($cart_item_id = null);
}
