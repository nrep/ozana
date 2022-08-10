<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_sex')->nullable()->after('customer_name');
            $table->string('customer_age')->nullable()->after('customer_sex');
            $table->string('customer_phone_number')->nullable()->after('customer_age');
            $table->unsignedBigInteger('insurance_discount_id')->nullable()->after('customer_phone_number');

            $table->foreign('insurance_discount_id')->references(('id'))->on('insurance_discounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['insurance_discount_id']);

            $table->dropColumn('customer_sex');
            $table->dropColumn('customer_age');
            $table->dropColumn('customer_phone_number');
            $table->dropColumn('insurance_discount_id');
        });
    }
};
