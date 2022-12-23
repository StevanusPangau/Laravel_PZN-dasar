<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvTest extends TestCase
{
    public function testGetEnv()
    {
        $yt = env('YOUTUBE');

        self::assertEquals('Programmer Zaman Now', $yt);
    }

    public function testGetEnvDefault()
    {
        $author = env('AUTHOR', 'Evan');

        self::assertEquals('Evan', $author);
    }
}
