<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testIsUser():void
    {
        $user = factory(\App\User::class)->create();
        $this->assertInstanceOf(\App\User::class, $user);
    }


}
