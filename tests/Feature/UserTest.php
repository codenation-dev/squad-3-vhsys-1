<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $token;
    protected $user;

    protected function setUp() : void
    {
        parent::setUp();
        $userFake = factory(\App\User::class)->create();
        $this->user = [
            'email' => $userFake->email,
            'password' => '123456'
        ];

        $token = $this->post(route('api.login'), $this->user)->getContent();
        $this->token = json_decode($token)->token;
    }

    public function testIsUser():void
    {
        $user = factory(\App\User::class)->create();
        $this->assertInstanceOf(\App\User::class, $user);
    }

    public function testRequisicaoValida():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
                            ->post(route('user.save'), [
                                'name' => 'Nome',
                                'email' => 'teste@teste.com',
                                'admin' => '1',
                                'password' => '123456'
        ]);

        $response->assertStatus(200);
    }

    public function testRequisicaoInvalida():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
                            ->post(route('user.save'), [
                                'name' => 'Nome',
                                'admin' => '1',
                                'password' => '123456'
        ]);

        $response->assertStatus(400);
    }

    public function testRequisicaoSemEmail():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
                    ->post(route('user.save'), [
                        'name' => 'Nome',
                        'admin' => '1',
                        'password' => '123456'
        ]);

        $response->assertStatus(400);
    }

    public function testBuscaUsuario():void
    {
        $user = factory(\App\User::class)->create();

        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('user.show', ["id" => $user->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testBuscaUsuarioInvalido():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('user.show', ["id" => "0"]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(404);
    }
}
