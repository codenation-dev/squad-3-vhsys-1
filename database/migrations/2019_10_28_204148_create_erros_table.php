<?php

use  Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


use Illuminate\Foundation\Auth\User as Authenticatable;

class CreateErrosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('erros', function (Blueprint $table) {
      $table->increments('id');
      $table->string('titulo');
      $table->text('descricao');
      $table->integer('eventos');
      $table->string('id_frequencia', 32);
      $table->string('status')->default('ativo');
      $table->string('nivel');
      $table->integer('ambiente');
      $table->string('origem');
      $table->string('usuario_name')->default('');
      $table->date('data');
      $table->integer('usuario_id')->unsigned();
      $table->foreign('usuario_id')->references('id')->on('users');
      $table->timestamps();});
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
