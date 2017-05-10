<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdFieldToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drawings', function (Blueprint $table) {
           $table->integer('user_id');
           $table->string('filename');
           $table->boolean('public');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('drawings', function (Blueprint $table) {
		$table->dropColumn('artist');
	});
    }
}
