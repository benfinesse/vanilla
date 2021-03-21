<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->boolean('active')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('last_seen')->nullable();
            $table->date('dob')->nullable();
            $table->bigInteger('countdown_pass')->nullable(); //countdown to expire token
            $table->bigInteger('countdown_otp')->nullable(); //countdown to expire otp
            $table->string('otp')->nullable(); //
            $table->string('token')->nullable(); //unique token to be used for dynamics
            $table->string('theme_type')->nullable();//dark theme or light theme
            $table->timestamp('email_verified_at')->nullable();
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
