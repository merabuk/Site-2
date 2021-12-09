<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsOwnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads_owns', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');

            $table->foreign('lead_id')->references('id')->on('leads')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['owner_id', 'lead_id', 'owner_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads_owns');
    }
}
