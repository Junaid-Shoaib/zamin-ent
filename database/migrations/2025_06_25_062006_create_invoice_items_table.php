<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            // $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->decimal('unit_price', 14, 2);
            $table->string('product_name')->nullable();
            $table->string('hs_code')->nullable();
            $table->string('uom')->nullable();
            $table->text('description');
            $table->decimal('quantity'. 12,2);
            $table->decimal('value_of_goods', 12, 2);
            $table->string('sale_Type')->default('Goods at standard rate (default)');
            $table->decimal('sale_tax_rate', 14, 2)->nullable();
            $table->decimal('amount_of_saleTax', 14, 2)->nullable();
            $table->decimal('sale_tax_withheld', 14, 2)->nullable();
            $table->decimal('extra_tax', 14, 2)->nullable();
            $table->decimal('further_tax', 14, 2)->nullable();
            $table->decimal('total', 14, 2);
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
        Schema::dropIfExists('invoice_items');
    }
}
