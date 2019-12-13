<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    use DatabaseMigrations;

    protected $token;

    protected function setUp() : void
    {
        parent::setUp();
        $userFake = factory(\App\User::class)->create();
        $user = [
            'email' => $userFake->email,
            'password' => '123456'
        ];

        $token = $this->post(route('api.login'), $user)->getContent();
        $this->token = json_decode($token)->token;
    }



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
