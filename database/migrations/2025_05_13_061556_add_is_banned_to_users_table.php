<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBannedToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('users', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->boolean('is_banned')->default(false);
    });
}

public function down()
{
    Schema::table('users', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('is_banned');
    });
}

}
