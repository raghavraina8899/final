<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceToProductUserTable extends Migration
{
    public function up()
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->after('quantity')->nullable(); // Adjust the position as needed
        });
    }

    public function down()
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
}
