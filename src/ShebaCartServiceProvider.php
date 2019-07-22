<?php
namespace YHShanto\ShebaCart;


use Illuminate\Support\ServiceProvider;

class ShebaCartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
