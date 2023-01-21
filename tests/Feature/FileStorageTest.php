<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        $fileSystem = Storage::disk('local');

        $fileSystem->put("file.txt", "Stevanus Evan Pangau");
        $content = $fileSystem->get("file.txt");

        assertEquals("Stevanus Evan Pangau", $content);
    }

    public function testPublic()
    {
        $fileSystem = Storage::disk('public');

        $fileSystem->put("file.txt", "Stevanus Evan Pangau");
        $content = $fileSystem->get("file.txt");

        assertEquals("Stevanus Evan Pangau", $content);
    }
}
