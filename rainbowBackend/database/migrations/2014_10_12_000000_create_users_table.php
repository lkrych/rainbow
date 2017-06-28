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
    public $colors = array('red','blue','yellow','green','purple','orange', 'yellow-green', 'blue-green', 'blue-violet', 'red-violet', 'red-orange', 'yellow-orange');

    public function randomColor()
    {
      return $this->colors[rand(0,count($this->colors) - 1)];
    }

    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('favorite_color')->default($this->randomColor());
            $table->string('email')->unique();
            $table->string('password');
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
