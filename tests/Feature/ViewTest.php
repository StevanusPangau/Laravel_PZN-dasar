<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testHello()
    {
        $this->get('/hello')->assertSeeText('Hello Evan');
        $this->get('/hello-again')->assertSeeText('Hello Evan Pangau');
    }

    public function testWorld()
    {
        $this->get('/hello-world')->assertSeeText('World Evan');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'Evan'])->assertSeeText('Hello Evan');
        $this->view('hello.world', ['name' => 'Evan'])->assertSeeText('World Evan');
    }
}
