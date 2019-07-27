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
     * @return mixed
     */
    function add($product_type = 'App\Product', $product_id, $quantity = 1, $price, $options = []);

    /**
     * @param string $product_type
     * @param $product_id
     * @param array $options
     * @return mixed
     */
    function update($product_type = 'App\Product', $product_id, $options = []);

    /**
     * @param string $product_type
     * @param $product_id
     * @return mixed
     */
    function remove($product_type = 'App\Product', $product_id);

    /**
     * @param string $product_type
     * @param $product_id
     * @return mixed
     */
    function get($product_type = 'App\Product', $product_id);

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
     * @return mixed
     */
    function total($prefix = null, $formatted = false);

    /**
     * @return mixed
     */
    function count();
}
