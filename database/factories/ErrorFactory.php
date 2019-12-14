<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Erro;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
 

$factory->define(Erro::class, function (Faker $faker) {

    $userFake = factory(\App\User::class)->create();

    $niveis = ["error", "warning", "debug"];
    $ambientes = ["1", "2", "3"];

    $nivel = Arr::random($niveis);
    $ambiente =Arr::random($ambientes);
    return [
        'titulo' => $faker->title,
        'descricao' => $faker->title,
        'eventos' => $faker->randomDigitNotNull,
        'id_frequencia' => Str::random(32),
        'status' => 'Ativo',
        'nivel' => $nivel,
        'ambiente' => $ambiente,
        'origem' =>'localhost',
        'usuario_name' => $userFake->name,
        'usuario_id' => $userFake->id,
        'data' => $faker->date()
    ];
});
