<?php

namespace YHShanto\ShebaCart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Traits\ForwardsCalls;

class CartInstance
{
    use ForwardsCalls;

    protected static $eloquent_driver;
    protected static $session_driver;
    protected $type = 'cart';

    public function guard()

    {
        return Auth::guard();
    }

    public function getEloquentDriver()

    {

        if (self::$eloquent_driver == null) self::$eloquent_driver = new EloquentCartDriver($this->type, $this->guard());
        return self::$eloquent_driver;

    }

    public function getSessionDriver()

    {

        if (self::$session_driver == null) self::$session_driver = new SessionCartDriver($this->type);
        return self::$session_driver;

    }

    public function detectDriver()

    {

        if ($this->guard()->check()) return $this->getEloquentDriver();
        return $this->getSessionDriver();

    }

    public function migrateToDatabase()

    {

        /** @var HasCart|Model $user */
        $user = $this->guard()->user();

        /** @var Collection $existingCart */
        $existingCart = $this->getSessionDriver()->getCollection();

        $this->getEloquentDriver()->destroy();

        $t = $this->type;
        $user->carts()->createMany($existingCart->map(function ($cartItem) use ($t) {
            $cartItem['cart_type'] = $t;
            return $cartItem;
        })->toArray());
        $this->getSessionDriver()->destroy();

    }

    public function __call($method, $parameters)

    {
        return $this->forwardCallTo($this->detectDriver(), $method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}
