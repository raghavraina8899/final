<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('reset_token', 255)->nullable()->after('remember_token');
            $table->timestamp('reset_token_expiration', 255)->nullable()->default('null')->after('reset_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('reset_token');
            $table->dropColumn('reset_token_expiration');
        });
    }
};
