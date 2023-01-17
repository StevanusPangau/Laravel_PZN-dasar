<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Evan')->assertSeeText('Hello Evan');
        $this->post('/input/hello', [
            'name' => 'Evan'
        ])->assertSeeText('Hello Evan');
    }

    public function testNestedInput()
    {
        $this->post('/input/hello/first', [
            'name' => [
                'first' => "Evan",
                'last' => "Pangau"
            ]
        ])->assertSeeText('Hello Evan');
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            'name' => [
                'first' => "Evan",
                'last' => "Pangau"
            ]
        ])->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('last')
            ->assertSeeText('Evan')
            ->assertSeeText('Pangau');
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            'products' => [
                [
                    'name' => "Apple Mac Book Pro",
                    'price' => 30000000
                ],
                [
                    'name' => "Samsung Galaxy S10",
                    'price' => 10000000
                ]
            ]
        ])->assertSeeText('Apple Mac Book Pro')->assertSeeText('Samsung Galaxy S10');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => "Evan",
            'married' => "true",
            'birth_date' => '2000-10-10'
        ])->assertSeeText('Evan')
            ->assertSeeText('true')
            ->assertSeeText('2000-10-10');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            'name' => [
                'first' => "Evan",
                'middle' => "Stevanus",
                'last' => "Pangau"
            ]
        ])->assertSeeText('Evan')
            ->assertSeeText('Pangau')
            ->assertDontSeeText('Stevanus');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            'username' => "Evan",
            'password' => "Rahasia",
            'admin' => "true",
        ])->assertSeeText('Evan')
            ->assertSeeText('Rahasia')
            ->assertDontSeeText('admin');
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            'username' => "Evan",
            'password' => "Rahasia",
            'admin' => "true",
        ])->assertSeeText('Evan')
            ->assertSeeText('Rahasia')
            ->assertSeeText('admin')
            ->assertSeeText('false');
    }
}
