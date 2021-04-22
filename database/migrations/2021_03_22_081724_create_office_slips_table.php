<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_slips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('user_id')->nullable();
            $table->uuid('user_id_2')->nullable(); // last update user id
            $table->uuid('record_id')->nullable();//current record uuid - reflecting pending action for record
            $table->uuid('office_id')->nullable();
            $table->string('status'); //pending, responded
            $table->boolean('approved')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('current')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users');
            $table->foreign('office_id')->references('uuid')->on('offices');
            $table->foreign('record_id')->references('uuid')->on('records');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('office_slips');
    }
}
