<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlendDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blend_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blend_id');
            $table->unsignedBigInteger('item_id');
            $table->float('qty');
            $table->float('sale_price' ,8, 2);
            $table->float('purchase_price' ,8, 2);
            $table->float('amount');
            $table->timestamps();

            $table->foreign('blend_id')
            ->references('id')
            ->on('blends')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blend_details');
    }
}
