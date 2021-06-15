<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkTeamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_team_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user')->nullable(false);
            $table->uuid('team')->nullable(false);
            $table->timestamps();
        });

        Schema::table('link_team_user', function (Blueprint $table) {
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_team_user');
    }
}
