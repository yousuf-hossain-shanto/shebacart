<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;

interface CartDriver
{
    /**
     * @param Model $service
     * @param int $quantity
     * @param $price
     * @param array $options
     * @return CartInstance
     */
    function add($service, $quantity = 1, $price, $options = []);

    /**
     * @param $service_id
     * @param array $option
     * @return CartInstance
     */
    function update($service_id, $option = []);

    /**
     * @param $service_id
     * @return CartInstance
     */
    function remove($service_id);

    /**
     * @param $service_id
     * @return Model
     */
    function get($service_id);

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
