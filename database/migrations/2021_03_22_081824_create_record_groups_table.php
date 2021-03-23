<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('user_id')->nullable();
            $table->uuid('record_id')->nullable();
            $table->uuid('group_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users');
            $table->foreign('group_id')->references('uuid')->on('groups');
            $table->foreign('record_id')
                ->references('uuid')
                ->on('records')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_groups');
    }
}
