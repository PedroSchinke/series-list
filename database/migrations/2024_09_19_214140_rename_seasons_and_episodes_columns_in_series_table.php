<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSeasonsAndEpisodesColumnsInSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->renameColumn('"seasonsQty"', 'seasons_qty');
            $table->renameColumn('"episodesPerSeason"', 'episodes_per_season');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->renameColumn('seasons_qty', '"seasonsQty"');
            $table->renameColumn('episodes_per_season', '"episodesPerSeason"');
        });
    }
}
