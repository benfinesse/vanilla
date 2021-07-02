<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('log_group_id')->nullable();
            $table->string('name')->nullable();
            $table->float('old_price')->nullable();
            $table->float('new_price')->nullable();
            $table->integer('old_qty')->nullable();
            $table->integer('new_qty')->nullable();
            $table->string('action_taken')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();

            $table->foreign('log_group_id')
                ->references('uuid')
                ->on('log_groups')
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
        Schema::dropIfExists('log_items');
    }
}
