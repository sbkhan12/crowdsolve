<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndAssigneeToProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::table('problems', function (Blueprint $table) {
        if (!Schema::hasColumn('problems', 'assigned_to')) {
            $table->string('assigned_to')->nullable();
        }

        if (!Schema::hasColumn('problems', 'status')) {
            $table->string('status')->default('pending');
        }
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('problems', function (Blueprint $table) {
            //
        });
    }
}
