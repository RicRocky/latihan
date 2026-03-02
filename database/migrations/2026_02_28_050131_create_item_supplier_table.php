<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_supplier', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')
                ->constrained("items")
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->constrained("suppliers")
                ->cascadeOnDelete();

            $table->double("harga");
            $table->integer("jumlah");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_supplier');
    }
}
