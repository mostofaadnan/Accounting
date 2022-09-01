<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category_id');
            $table->text('name');
            $table->text('description')->nullable();
            $table->boolean('sale');
            $table->boolean('purchase');
            $table->string('type');
            $table->float('purchase_price');
            $table->float('sale_price');
            $table->float('opening_stock');
            $table->string('unit')->default('Kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
