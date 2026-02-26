<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Gagal Mindahin Posisi Kolom
class ReorderGudangIdColumnOnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('items', function (Blueprint $table) {
        //     $table->dropForeign(["gudang_id"]);

        //     $table->unsignedBigInteger('gudang_id')
        //         ->after('harga')
        //         ->change();

        //     $table->foreign("gudang_id")
        //         ->references("id")
        //         ->on("gudangs");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table("items", function (Blueprint $table) {
        //     $table->dropForeign(["gudang_id"]);

        //     $table->unsignedBigInteger("gudang_id")
        //         ->after("deleted_at")
        //         ->change();

        //     $table->foreign("gudang_id")
        //         ->references("id")
        //         ->on("gudangs");
        // });
    }
}
