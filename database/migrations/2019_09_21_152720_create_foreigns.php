<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('no action');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('no action');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('sessions_groups', function (Blueprint $table) {
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });

        Schema::table('types_rights', function (Blueprint $table) {
            $table->foreign('user_type_id')->references('id')->on('users_types')->onDelete('cascade');
            $table->foreign('right_id')->references('id')->on('rights')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('user_type_id')->references('id')->on('users_types')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropForeign('user_id');
            $table->dropForeign('created_by');
            $table->dropForeign('session_id');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });

        Schema::table('sessions_groups', function (Blueprint $table) {
            $table->dropForeign('session_id');
            $table->dropForeign('group_id');
        });

        Schema::table('types_rights', function (Blueprint $table) {
            $table->dropForeign('user_type_id');
            $table->dropForeign('right_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('user_type_id');
            $table->dropForeign('group_id');
        });
    }
}
