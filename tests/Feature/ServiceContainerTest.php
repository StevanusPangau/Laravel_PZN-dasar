<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        // $foo = new Foo();
        $foo1 = app()->make(Foo::class); // new foo
        $foo2 = app()->app->make(Foo::class); // new foo

        assertEquals('Foo', $foo1->foo());
        assertEquals('Foo', $foo2->foo());
        assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        // $person = app()->make(Person::class); // new Person()
        // assertNotNull($person);

        app()->bind(Person::class, function ($app) {
            return new Person("Evan", "Pangau");
        }); // bikin bind jika functionya memliki parameter atau ada object yang kompleks

        $person1 = app()->make(Person::class); // closure() // new Person("Evan", "Pangau")
        $person2 = app()->make(Person::class); // closure() // new Person("Evan", "Pangau")

        assertEquals("Evan", $person1->firstName);
        assertEquals("Evan", $person2->firstName);
        assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        app()->singleton(Person::class, function ($app) {
            return new Person("Evan", "Pangau");
        }); // bikin bind jika functionya memliki parameter atau ada object yang kompleks

        $person1 = app()->make(Person::class); // new Person("Evan", "Pangau")
        $person2 = app()->make(Person::class); // return existing (mengembalikan yang sudah ada)

        assertEquals("Evan", $person1->firstName);
        assertEquals("Evan", $person2->firstName);
        assertSame($person1, $person2); // dari notsame diganti jadi same karena object yang digunakan sama
    }

    public function testInstance()
    {
        $person = new Person("Evan", "Pangau");
        app()->instance(Person::class, $person); // bikin bind jika functionya memliki parameter atau ada object yang kompleks

        $person1 = app()->make(Person::class); // object $person
        $person2 = app()->make(Person::class); // object $person

        assertEquals("Evan", $person1->firstName);
        assertEquals("Evan", $person2->firstName);
        assertSame($person1, $person2); // dari notsame diganti jadi same karena object yang digunakan sama
    }

    public function testDependencyInjection()
    {
        app()->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        app()->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = app()->make(Foo::class);
        $bar1 = app()->make(Bar::class);
        $bar2 = app()->make(Bar::class);

        assertSame($foo, $bar1->foo);
        assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        // app()->singleton(HelloService::class, HelloServiceIndonesia::class); //Bisa Pakai Cara Ini (jika tidak kompleks)

        app()->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        }); // atau bisa pakai cara ini (jika kompleks atau memiliki parameter)

        $helloService = app()->make(HelloService::class);

        assertEquals("Halo Evan", $helloService->hello("Evan"));
    }
}
