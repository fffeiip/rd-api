<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkDynamicsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_dynamics_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('participant')->nullable(false);
            $table->uuid('dynamics')->nullable(false);
            $table->uuid('created_by')->nullable(false);
            $table->timestamps();
        });

        Schema::table('link_dynamics_user', function (Blueprint $table) {
            $table->foreign('dynamics')->references('id')->on('dynamics');
            $table->foreign('participant')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_dinamica_usuario');
    }
}
