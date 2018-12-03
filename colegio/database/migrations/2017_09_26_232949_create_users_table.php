<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('id de usuario')->unique();
            $table->string('email',100)->unique()->comment('correo de usuario');
            $table->string('avatar',128)->default('avatar.png');
            $table->string('password',255)->comment('clave encriptada usuario');
            $table->string('clave',32)->comment('clave de usuario');
            $table->integer('tipo_id')->unsigned()->comment('Codigo de tipo usuario');
            $table->foreign('tipo_id')->references('id')->on('tipo_user')->onDelete('cascade');
            $table->string('cedula',15)->unique()->comment('cedula de usuario');
            $table->string('nombre',50)->comment('nombre de usuario');
            $table->string('apellido',50)->comment('apellido de usuario');
            $table->string('telefono',15)->comment('telefono de usuario');
            $table->string('est',1)->comment('???est de usuario');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
