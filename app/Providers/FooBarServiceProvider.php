<?php

namespace App\Providers;

use App\Data\Foo;
use App\Data\Bar;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HelloService::class => HelloServiceIndonesia::class
    ];

    public function register()
    {
        // echo "Test FoobarServiceProvider\n";
        app()->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        app()->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [HelloService::class, Foo::class, Bar::class]; //berfungsi untuk menentukan jika service provider ada yang dipanggil, jika tidak maka tidak akan jilankan
    }
}
