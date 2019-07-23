<?php
namespace YHShanto\ShebaCart\Contracts;


use Illuminate\Database\Eloquent\Model;

interface CartDriver
{
    /**
     * @param $product_id
     * @param int $quantity
     * @param $price
     * @param array $options
     * @return CartInstance
     */
    function add($product_id, $quantity = 1, $price, $options = []);

    /**
     * @param $product_id
     * @param array $options
     * @return CartInstance
     */
    function update($product_id, $options = []);

    /**
     * @param $product_id
     * @return CartInstance
     */
    function remove($product_id);

    /**
     * @param $product_id
     * @return Model
     */
    function get($product_id);

    /**
     * @return CartInstance
     */
    function all();

    /**
     * @return boolean
     */
    function destroy();

    /**
     * @param null $prefix
     * @param bool $formatted
     * @return mixed
     */
    function total($prefix = null, $formatted = false);

    /**
     * @return integer
     */
    function count();
}
