<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ErrorTest extends TestCase
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

    // public function testDatabase()
    // {
    //     // Make call to application...
    //     $u = new \App\User();
    //     $u->name = "Nome";
    //     $u->email = "teste@teste.com";
    //     $u->admin = '1';
    //     $u->password = '$2y$10$YPDvYV/jAuxxJlWUPaOBT.2qBbPpspLpfqNqrxVS6P.FrSh/gY/by';
    //     $u->remember_token = Str::random(10);
    //     $u->save();

    //     $this->assertDatabaseHas('users', [
    //         'email' => $u->email
    //     ]);
    // }

    public function testRequisicaoValida():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
                         ->post(route('erros.save'), [
                        'titulo' => 'Erro 23',
                        'descricao' => 'Descrição do erro',
                        'nivel' => 'error',
                        'ambiente' => '1',
                        'origem' =>'localhost',

        ]);

        $response->assertStatus(200);

    }

    public function testRequisicaoInvalida():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
                         ->post(route('erros.save'), [
                        'titulo' => 'Erro 23',
                        'descricao' => 'Descrição do erro',
                        'nivel' => 'errorr',
        ]);

        $response->assertStatus(400);
    }
}
