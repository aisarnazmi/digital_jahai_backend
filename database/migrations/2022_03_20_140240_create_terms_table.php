<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('jahai_term', 255)->nullable();
            $table->string('malay_term', 255)->nullable();
            $table->string('english_term', 255)->nullable();
            $table->longText('description')->nullable();
            $table->longText('malay_description')->nullable();
            $table->longText('english_description')->nullable();
            $table->string('term_category', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
