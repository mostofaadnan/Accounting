<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->text('purchase_date');
            $table->text('purchase_no');
            $table->unsignedBigInteger('vendor_id');
            $table->text('order_no')->nullable();
            $table->float('amount' ,8, 2);
            $table->float('discount' ,8, 2);
            $table->float('nettotal' ,8, 2);
            $table->tinyInteger('payment_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('cancel')->default(0);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('purchases');
    }
}
