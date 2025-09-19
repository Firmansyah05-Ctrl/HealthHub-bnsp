<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->bigInteger('price')->change();
    });

    Schema::table('orders', function (Blueprint $table) {
        $table->bigInteger('total_amount')->change();
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->bigInteger('price_per_item')->change();
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('price', 15, 2)->change();
    });

    Schema::table('orders', function (Blueprint $table) {
        $table->decimal('total_amount', 15, 2)->change();
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->decimal('price_per_item', 15, 2)->change();
    });
}


};
