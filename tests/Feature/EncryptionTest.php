<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt('Evan Pangau');
        var_dump($encrypt);

        $decrypt = Crypt::decrypt($encrypt);

        assertEquals('Evan Pangau', $decrypt);
    }
}
