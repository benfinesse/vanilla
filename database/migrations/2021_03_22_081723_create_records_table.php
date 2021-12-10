<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('user_id')->nullable();
            $table->uuid('office_id')->nullable();//current office submitted to
            $table->uuid('process_id')->nullable();//current process running
            $table->integer('stage')->nullable(); //1 , 2 , 3 , 4 i.e Stage ID
            $table->boolean('completed')->nullable();
            $table->boolean('active')->nullable();
            $table->string('title')->nullable();
            $table->string('fund_source')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users');
            $table->foreign('office_id')->references('uuid')->on('offices');
            $table->foreign('process_id')->references('uuid')->on('office_processes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
