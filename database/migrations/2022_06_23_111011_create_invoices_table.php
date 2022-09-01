<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->text('invoice_date');
            $table->text('invoice_no');
            $table->unsignedBigInteger('customer_id');
            $table->text('order_no')->nullable();
            $table->float('amount' ,8, 2);
            $table->float('discount' ,8, 2);
            $table->float('nettotal' ,8, 2);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('cancel')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->text('deliverydate')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
