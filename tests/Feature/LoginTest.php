<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    protected function setUp() : void
    {
        parent::setUp();
        $userFake = factory(\App\User::class)->create();
        $this->user = [
            'email' => $userFake->email,
            'password' => '123456'
        ];
    }

    public function testLogin():void
    {
        $response = $this->post(route('api.login'), $this->user);

        $response->assertStatus(201);
    }

    public function testLoginNaoAutorizado():void
    {
        $user = [
            'email' => "admin@admin.com",
            'password' => '12345'
        ];
        $response = $this->post(route('api.login'), $user);

        $response->assertStatus(401);
    }

    public function testLogout():void
    {
        $response = $this->post(route('api.login'), $this->user);
        $response->assertStatus(201);
    
        $response = $this->get(route('api.logout'), $this->user);
        $response->assertStatus(201);
    }

    public function testLogoutInvalido():void
    {
        $user = [
            'email' => 'admin@admin.com',
            'password' => '12345'
        ];
        $response = $this->get(route('api.logout'), $user);

        $response->assertStatus(201);
    }
}