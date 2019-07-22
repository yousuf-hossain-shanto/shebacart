<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;

class EloquentCartDriver implements CartDriver
{
    protected $instance;

    public function __construct($instance)

    {
        $this->instance = $instance;
    }

    /**
     * @param Model $service
     * @param int $quantity
     * @param $price
     * @param array $options
     * @return CartInstance
     */
    function add($service, $quantity = 1, $price, $options = [])
    {
        // TODO: Implement add() method.
    }

    /**
     * @param $service_id
     * @param array $option
     * @return CartInstance
     */
    function update($service_id, $option = [])
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $service_id
     * @return CartInstance
     */
    function remove($service_id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $service_id
     * @return Model
     */
    function get($service_id)
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
