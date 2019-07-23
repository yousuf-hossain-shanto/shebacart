<?php
namespace YHShanto\ShebaCart;

class CartInstance
{

    protected static $driver;
    protected static $type;

    public static function setDriver( string $name )

    {

        if (! in_array($name, ['session', 'database']) || $name == 'session') self::$driver = new SessionCartDriver(self::$type);

//        if ($name == 'database') self::$driver = new EloquentCartDriver(self::)

    }

}
