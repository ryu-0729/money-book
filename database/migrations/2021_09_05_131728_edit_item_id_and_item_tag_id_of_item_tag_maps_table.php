<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditItemIdAndItemTagIdOfItemTagMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_tag_maps', function (Blueprint $table) {
            $table->integer('item_id')->unsigned()->change();
            $table->integer('item_tag_id')->unsigned()->change();

            $table->dropForeign(['item_id']);
            $table->dropForeign(['item_tag_id']);

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();

            $table->foreign('item_tag_id')
                ->references('id')
                ->on('item_tags')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_tag_maps', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['item_tag_id']);

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('cascade')
                ->change();

            $table->foreign('item_tag_id')
                ->references('id')
                ->on('item_tags')
                ->onUpdate('cascade')
                ->change();
        });
    }
}
