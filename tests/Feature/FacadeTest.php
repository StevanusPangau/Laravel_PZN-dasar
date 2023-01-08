<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class FacadeTest extends TestCase
{
    public function testConfig()
    {
        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        assertEquals($firstName1, $firstName2);

        // var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        // bisa mengunakan ini jika tidak mengunakan facades
        $config = app()->make('config');
        $firstName3 = $config->get('contoh.author.first');

        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        assertEquals($firstName1, $firstName2);
        assertEquals($firstName1, $firstName3);

        // var_dump($config->all());
    }

    // Mocking
    public function testFacadeMock()
    {
        Config::shouldReceive('get')->with('contoh.author.first')->andReturn('Evan Keren'); // Facade ada shouldReceive untuk mocking

        $firstName = Config::get('contoh.author.first');

        assertEquals('Evan Keren', $firstName);
    }
}
