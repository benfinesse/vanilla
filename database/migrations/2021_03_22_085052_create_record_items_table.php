<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('user_id')->nullable();
            $table->uuid('record_id')->nullable();
            $table->uuid('record_group_id')->nullable();
            $table->uuid('measure')->nullable();
            $table->float('stock_outside')->nullable();
            $table->float('stock_store')->nullable();
            $table->string('type')->nullable(); //credit //cash
            $table->string('name')->nullable();
            $table->float('qty', 10, 2)->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->boolean('excluded')->nullable();
            $table->float('true_qty', 10, 2)->nullable();
            $table->float('true_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users');
            $table->foreign('record_group_id')->references('uuid')->on('record_groups');
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
        Schema::dropIfExists('record_items');
    }
}
