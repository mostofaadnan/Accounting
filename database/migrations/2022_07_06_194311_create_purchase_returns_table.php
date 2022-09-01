<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->text('return_date');
            $table->text('return_no');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('purchase_trn_no');
            $table->unsignedBigInteger('vendor_id');
            $table->tinyInteger('return_type');
            $table->float('amount' ,8, 2);
            $table->float('discount' ,8, 2);
            $table->float('nettotal' ,8, 2);
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
        Schema::dropIfExists('purchase_returns');
    }
}
