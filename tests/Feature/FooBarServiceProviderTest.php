<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

class FooBarServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $foo1 = app()->make(Foo::class);
        $foo2 = app()->make(Foo::class);

        assertSame($foo1, $foo2);

        $bar1 = app()->make(Bar::class);
        $bar2 = app()->make(Bar::class);

        assertSame($bar1, $bar2);

        assertSame($foo1, $bar1->foo);
        assertSame($foo2, $bar2->foo);
    }

    public function testPropertySingletons()
    {
        $helloService1 = app()->make(HelloService::class);
        $helloService2 = app()->make(HelloService::class);

        assertSame($helloService1, $helloService2);

        assertEquals("Halo Evan", $helloService1->hello('Evan'));
    }

    public function testEmpty()
    {
        assertTrue(true);
    }
}
