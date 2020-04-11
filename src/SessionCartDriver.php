<?php

namespace YHShanto\ShebaCart;

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
     * @param null $tax
     * @param array $config
     * @return mixed
     */
    function add($product_type = 'App\Product', $product_id, $quantity = 1, $price, $options = [], $tax = null, $config = [])
    {
        $newCollection = collect([
            'id' => uniqid($this->cart_type . '-'),
            'product_type' => $product_type,
            'product_id' => $product_id,
            'price' => $price,
            'tax' => $tax,
            'quantity' => $quantity,
            'options' => $options,
            'config' => $config
        ]);
        $this->getCollection()->push($newCollection);
        $this->triggerChange();
        return $this->get($product_type, $product_id);
    }

    function find($product_type = 'App\Product', $product_id, $cart_item_id = null)
    {
        $index = -1;
        if ($cart_item_id) {
            $index = $this->getCollection()->search(function ($item, $key) use ($cart_item_id) {
                return $cart_item_id == $item['id'];
            });
        } else {
            $index = $this->getCollection()->search(function ($item, $key) use ($product_type, $product_id) {
                return $product_type == $item['product_type'] && $item['product_id'] == $product_id;
            });
        }

        return ($index >= 0) ? $index : -1;
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
        $index = $this->find($product_type, $product_id, $cart_item_id);
        if ($index == -1) return false;
        if ($this->getCollection()[$index] && count($options)) {
            foreach ($options as $property => $value) {
                $this->getCollection()[$index][$property] = $value;
            }

            $this->triggerChange();
        }
        return $this->getCollection()[$index];
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function remove($product_type = 'App\Product', $product_id, $cart_item_id = null)
    {
        $index = $this->find($product_type, $product_id, $cart_item_id);
        $res = $index != -1 ? $this->getCollection()->splice($index, 1) : false;
        return $res ? $this->triggerChange() : false;
    }

    /**
     * @param string $product_type
     * @param $product_id
     * @param null $cart_item_id
     * @return mixed
     */
    function get($product_type = 'App\Product', $product_id, $cart_item_id = null)
    {
        $index = $this->find($product_type, $product_id, $cart_item_id);
        $product = $index != -1 ? $this->getCollection()[$index] : null;

        return $product ? [
            'id' => $product['id'],
            'product_type' => $product_type,
            'product' => ($product['product_type'])::find($product['product_id']),
            'price' => $product['price'],
            'tax' => $product['tax'],
            'quantity' => $product['quantity'],
            'options' => $product['options'],
            'config' => $product['config']
        ] : null;
    }

    /**
     * @return mixed
     */
    function all()
    {
        return $this->getCollection()->map(function ($item) {
            return [
                'id' => $item['id'],
                'product_type' => $item['product_type'],
                'product' => ($item['product_type'])::find($item['product_id']),
                'price' => $item['price'],
                'tax' => $item['tax'],
                'quantity' => $item['quantity'],
                'options' => $item['options'],
                'config' => $item['config']
            ];
        })->all();
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
     * @param bool $withTax
     * @return mixed
     */
    function total($prefix = null, $formatted = false, $withTax = false)
    {
        $total = $this->getCollection()->map(function ($item, $index) use ($withTax) {
            if ($withTax) return ($item['price'] + $item['tax']) * $item['quantity'];
            return $item['price'] * $item['quantity'];
        })->sum();

        if ($formatted) $total = number_format($total);

        return $prefix ? $prefix . $total : $total;

    }

    /**
     * @param null $cart_item_id
     * @return mixed
     */
    function count($cart_item_id = null)
    {
        if ($cart_item_id) {
            $index = $this->find(null, null, $cart_item_id);
            return $index != -1 ? $this->getCollection()[$index]['quantity'] : 0;
        }
        return $this->getCollection()->sum('quantity');
    }
}
