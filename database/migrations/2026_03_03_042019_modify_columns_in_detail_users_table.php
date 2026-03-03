<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsInDetailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_users', function (Blueprint $table) {
            $table->dropColumn("provinsi");
            $table->dropColumn("kota");
            $table->dropColumn("kecamatan");

            $table->string("kelurahan", 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_users', function (Blueprint $table) {
            $table->string("provinsi");
            $table->string("kota");
            $table->string("kecamatan");

            $table->string("kelurahan")->change();
        });
    }
}
