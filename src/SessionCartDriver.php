<?php
namespace YHShanto\ShebaCart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use YHShanto\ShebaCart\Contracts\CartDriver;

class SessionCartDriver implements CartDriver
{
    protected $cart_type;

    /**
     * @var $collection Collection
     */
    private static $collection;

    public function __construct($cart_type)

    {
        $this->cart_type = $cart_type;
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
            self::$collection = $this->getSession()->get('cart-' . $this->cart_type, collect());
        }
        return self::$collection;

    }

    public function triggerChange()

    {

        return $this->getSession()->put('cart-' . $this->cart_type, $this->getCollection());

    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param int $quantity
     * @param $price
     * @param array $options
     * @return mixed
     */
    function add($product_type = 'App\Product', $product_id, $quantity = 1, $price, $options = [])
    {
        $newCollection = collect([
            'product_type' => $product_type,
            'product_id' => $product_id,
            'price' => $price,
            'quantity' => $quantity,
            'options' => $options
        ]);
        $this->getCollection()->push($newCollection);
        $this->triggerChange();
        return $newCollection;
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param array $options
     * @return mixed
     */
    function update($product_type = 'App\Product', $product_id, $options = [])
    {
        $collection = $this->get($product_type = 'App\Product', $product_id);

        if ($collection && count($options)) {
            foreach ($options as $property => $value) {
                $collection[$property] = $value;
            }
            $this->triggerChange();
        }
        return $collection;
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @return mixed
     */
    function remove($product_type = 'App\Product', $product_id)
    {
        $index = $this->getCollection()->search(function ($item, $key) use ($product_type, $product_id) {
            return $item->product_type == $product_type && $item->product_id == $product_id;
        });
        $res = $index ? $this->getCollection()->splice($index, 1) : false;
        return $res ? $this->triggerChange() : false;
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @return mixed
     */
    function get($product_type = 'App\Product', $product_id)
    {
        return $this->getCollection()->where('product_type', $product_type)->where('product_id', $product_id)->first();
    }

    /**
     * @return mixed
     */
    function all()
    {
        return $this->getCollection()->all();
    }

    /**
     * @return mixed
     */
    function destroy()
    {
        self::$collection = null;
        return $this->getSession()->forget('cart-' . $this->cart_type);
    }

    /**
     * @param null $prefix
     * @param bool $formatted
     * @return mixed
     */
    function total($prefix = null, $formatted = false)
    {
        $total = $this->getCollection()->map(function ($item, $index) {
            return $item->price*$item->quantity;
        })->sum();

        if ($formatted) $total = number_format($total);

        return $prefix?$prefix . $total:$total;

    }

    /**
     * @return mixed
     */
    function count()
    {
        return $this->getCollection()->sum('quantity');
    }
}
