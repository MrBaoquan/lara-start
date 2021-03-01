<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWxUserFieldsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('openid', 255)->unique();
            $table->string('nick_name', 30)->nullable();
            $table->integer('gender')->default(0);
            $table->string('country', 20)->nullable();
            $table->string('province', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->text('avatar_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('openid');
            $table->dropColumn('nick_name');
            $table->dropColumn('gender');
            $table->dropColumn('country');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('avatar_url');
        });
    }
}
