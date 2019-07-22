<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SessionCartDriver implements CartDriver
{
    protected $instance;

    /**
     * @var $collection Collection
     */
    private static $collection;

    public function __construct($instance)

    {
        $this->instance = $instance;
    }

    /**
     * @return mixed|\Illuminate\Session\Store|\Illuminate\Session\SessionManager
     */
    public function getSession()
    {
        return app('session');
    }

    public function getCollection()

    {

        if (self::$collection == null) {
            self::$collection = $this->getSession()->get('cart-' . $this->instance, collect());
        }
        return self::$collection;

    }

    public function triggerChange()

    {

        return $this->getSession()->put('cart-' . $this->instance, $this->getCollection());

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
        $newCollection = collect([
            'service' => $service,
            'price' => $price,
            'quantity' => $quantity,
            'options' => $options
        ]);
        $this->getCollection()->push($newCollection);
        return $this->triggerChange();
    }

    /**
     * @param $service_id
     * @param array $option
     * @return CartInstance
     */
    function update($service_id, $option = [])
    {
        $collection = $this->get($service_id);

        if ($collection && count($option)) {
            foreach ($option as $property => $value) {
                $collection[$property] = $value;
            }
            $this->triggerChange();
        }
    }

    /**
     * @param $service_id
     * @return CartInstance
     */
    function remove($service_id)
    {
        $index = $this->getCollection()->search(function ($item, $key) use ($service_id) {
            return $item->service->id == $service_id;
        });
        $res = $index?$this->getCollection()->splice($index, 1):false;
        return $res?$this->triggerChange():false;
    }

    /**
     * @param $service_id
     * @return Model|null
     */
    function get($service_id)
    {
        return $this->getCollection()->where('service.id', $service_id)->first();
    }

    /**
     * @return CartInstance
     */
    function all()
    {
        return $this->getCollection()->all();
    }

    /**
     * @return boolean
     */
    function destroy()
    {
        self::$collection = null;
        return $this->getSession()->forget('cart-' . $this->instance);
    }

    /**
     * @param null $prefix
     * @param bool $formatted
     * @return mixed
     */
    function total($prefix = null, $formatted = true)
    {
        $total = $this->getCollection()->sum('price');

        if ($formatted) $total = number_format($total);

        return $prefix?$prefix . $total:$total;
    }

    /**
     * @return integer
     */
    function count()
    {
        return $this->getCollection()->sum('quantity');
    }
}
