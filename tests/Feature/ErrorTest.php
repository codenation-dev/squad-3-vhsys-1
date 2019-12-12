<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorTest extends TestCase
{
    use DatabaseMigrations;

    public function testRequisicaoValida():void
    {
         $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)
                         ->post(route('erros.store'), [
                        'titulo' => 'Erro 23',
                        'descricao' => 'Descrição do erro',
                        'eventos' => '235',
                        'nivel' => 'Error',
                        'data' => '2019-11-30'
        ]);

        $response->assertStatus(200);

    }

    public function testRequisicaoInvalida():void
    {
         $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)
                         ->post(route('erros.store'), [
                        'titulo' => 'Erro 23',
                        'descricao' => 'Descrição do erro',
                        'eventos' => '235',
                        'nivel' => 'Errorr',
                        'data' => '2019-11-30'
        ]);

        $response->assertStatus(422);

    }
}
