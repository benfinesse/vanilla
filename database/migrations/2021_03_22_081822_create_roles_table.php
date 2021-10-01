<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->uuid('user_id')->nullable();
            $table->string('title')->nullable();
            $table->boolean('create_user')->nullable();
            $table->boolean('edit_user')->nullable();
            $table->boolean('delete_user')->nullable();
            $table->boolean('create_role')->nullable();
            $table->boolean('edit_role')->nullable();
            $table->boolean('delete_role')->nullable();
            $table->boolean('create_record')->nullable();
            $table->boolean('edit_record')->nullable();
            $table->boolean('delete_record')->nullable();
            $table->boolean('create_group')->nullable();
            $table->boolean('edit_group')->nullable();
            $table->boolean('delete_group')->nullable();
            $table->boolean('create_process')->nullable();
            $table->boolean('edit_process')->nullable();
            $table->boolean('delete_process')->nullable();
            $table->boolean('create_measure')->nullable();
            $table->boolean('edit_measure')->nullable();
            $table->boolean('delete_measure')->nullable();
            $table->boolean('create_product')->nullable();
            $table->boolean('edit_product')->nullable();
            $table->boolean('delete_product')->nullable();
            $table->boolean('create_office')->nullable();
            $table->boolean('edit_office')->nullable();
            $table->boolean('delete_office')->nullable();
            $table->boolean('modify_office_member')->nullable();
            $table->boolean('view_processes')->nullable();
            $table->boolean('view_groups')->nullable();
            $table->boolean('view_measure')->nullable();
            $table->boolean('view_users')->nullable();
            $table->boolean('view_roles')->nullable();
            $table->boolean('administration')->nullable();
            $table->boolean('settings')->nullable();
            $table->boolean('procurement')->nullable();
            $table->boolean('view_supplier')->nullable();
            $table->boolean('create_supplier')->nullable();
            $table->boolean('edit_supplier')->nullable();
            $table->boolean('delete_supplier')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('uuid')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
