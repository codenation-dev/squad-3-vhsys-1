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
    protected $log;

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

        $this->log = factory(\App\Erro::class)->create();
    }

    public function testIsErro():void
    {
        $log = factory(\App\Erro::class)->create();
        $this->assertInstanceOf(\App\Erro::class, $log);
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
                        'nivel' => 'errorr'
        ]);

        $response->assertStatus(400);
    }

    public function testPesquisaErroPorStatus():void 
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
            ->get(route('erros.index'));

        $response->assertStatus(200);
    }
    

    public function testPesquisaErroPorAmbiente():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["ambiente" => $this->log->ambiente], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testPesquisaErroPorNivel():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["nivel" => $this->log->nivel], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testPesquisaErroPorTitulo():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["titulo" => $this->log->titulo], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testPesquisaErroPorDescricao():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["descricao" => $this->log->descricao], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testPesquisaErroPorOrigem():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["origem" => $this->log->origem], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testPesquisaOrdenadaPorNivel():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.index'), 
            ["order" => "1"], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testAtualizarQuantidade():void
    {
        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
            ->post(route('erros.save'), [
                'titulo' => $this->log->titulo,
                'descricao' => $this->log->descricao,
                'nivel' => $this->log->nivel,
                'ambiente' => $this->log->ambiente,
                'origem' => $this->log->origem,
        ]);

        $response->assertStatus(200);

        $response = $this->withHeaders(['Authorization' => 'bearer'.$this->token])
            ->post(route('erros.save'), [
                'titulo' => $this->log->titulo,
                'descricao' => $this->log->descricao,
                'nivel' => $this->log->nivel,
                'ambiente' => $this->log->ambiente,
                'origem' => $this->log->origem,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('erros', ['eventos' => '2']);
    }

    public function testBuscarErro():void
    {
        $userFake = factory(\App\User::class)->create();

        $e = new \App\Erro();
        $e->titulo = $this->log->titulo;
        $e->descricao = $this->log->descricao;
        $e->eventos = $this->log->eventos;
        $e->id_frequencia = $this->log->id_frequencia;
        $e->status = $this->log->status;
        $e->nivel = $this->log->nivel;
        $e->ambiente = $this->log->ambiente;
        $e->origem = $this->log->origem;
        $e->usuario_name = $userFake->name;
        $e->usuario_id = $userFake->id;
        $e->data = $this->log->data;
        $e->save();

        $user = [
            'email' => $userFake->email,
            'password' => '123456'];

        $token = $this->post(route('api.login'), $user)->getContent();
        $token = json_decode($token)->token;

        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.show', ["id" => $e->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testBuscarErroInvalido():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'GET', 
            route('erros.show', ["id" => "0"]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(404);
    }

    public function testArquivarErro():void
    {     
        $userFake = factory(\App\User::class)->create();

        $e = new \App\Erro();
        $e->titulo = $this->log->titulo;
        $e->descricao = $this->log->descricao;
        $e->eventos = $this->log->eventos;
        $e->id_frequencia = $this->log->id_frequencia;
        $e->status = $this->log->status;
        $e->nivel = $this->log->nivel;
        $e->ambiente = $this->log->ambiente;
        $e->origem = $this->log->origem;
        $e->usuario_name = $userFake->name;
        $e->usuario_id = $userFake->id;
        $e->data = $this->log->data;
        $e->save();

        $user = [
            'email' => $userFake->email,
            'password' => '123456'];

        $token = $this->post(route('api.login'), $user)->getContent();
        $token = json_decode($token)->token;

        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'PATCH', 
            route('erros.store', ["id" => $e->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
    }

    public function testArquivarErroJaArquivado():void
    {
        $userFake = factory(\App\User::class)->create();

        $e = new \App\Erro();
        $e->titulo = $this->log->titulo;
        $e->descricao = $this->log->descricao;
        $e->eventos = $this->log->eventos;
        $e->id_frequencia = $this->log->id_frequencia;
        $e->status = $this->log->status;
        $e->nivel = $this->log->nivel;
        $e->ambiente = $this->log->ambiente;
        $e->origem = $this->log->origem;
        $e->usuario_name = $userFake->name;
        $e->usuario_id = $userFake->id;
        $e->data = $this->log->data;
        $e->save();

        $user = [
            'email' => $userFake->email,
            'password' => '123456'];

        $token = $this->post(route('api.login'), $user)->getContent();
        $token = json_decode($token)->token;

        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'PATCH', 
            route('erros.store', ["id" => $e->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(200);
        
        $response = $this->call(
            'PATCH', 
            route('erros.store', ["id" => $e->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(400);
    }

    public function testArquivarErroInexistente():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'PATCH', 
            route('erros.store', ["id" => "0"]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(404);
    }


    public function testApagarErro():void
    {
        $userFake = factory(\App\User::class)->create();

        $e = new \App\Erro();
        $e->titulo = $this->log->titulo;
        $e->descricao = $this->log->descricao;
        $e->eventos = $this->log->eventos;
        $e->id_frequencia = $this->log->id_frequencia;
        $e->status = $this->log->status;
        $e->nivel = $this->log->nivel;
        $e->ambiente = $this->log->ambiente;
        $e->origem = $this->log->origem;
        $e->usuario_name = $userFake->name;
        $e->usuario_id = $userFake->id;
        $e->data = $this->log->data;
        $e->save();

        $user = [
            'email' => $userFake->email,
            'password' => '123456'];

        $token = $this->post(route('api.login'), $user)->getContent();
        $token = json_decode($token)->token;

        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'DELETE', 
            route('erros.destroy', ["id" => $e->id]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(400);
    }

    public function testApagarErroInexistente():void
    {
        $server = $this->transformHeadersToServerVars(['Authorization' => 'bearer'.$this->token]);
        $cookies = $this->prepareCookiesForRequest();
        $response = $this->call(
            'DELETE', 
            route('erros.destroy', ["id" => "0"]), 
            [], 
            $cookies, 
            [], 
            $server);

        $response->assertStatus(404);
    }

}
