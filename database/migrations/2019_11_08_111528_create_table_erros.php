<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableErros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id');

            $table->string('titulo');
            $table->text('descricao');
            $table->integer('eventos');
            $table->string('status')->default('ativo');
            $table->string('nivel');
            $table->string('usuario_name')->default('');
            $table->date('data');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erros');
    }
}
