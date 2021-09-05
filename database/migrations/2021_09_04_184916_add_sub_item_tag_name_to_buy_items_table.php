<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubItemTagNameToBuyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_items', function (Blueprint $table) {
            $table->string('sub_item_tag_name')->nullable()->after('item_tag_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_items', function (Blueprint $table) {
            $table->dropColumn('sub_item_tag_name');
        });
    }
}
