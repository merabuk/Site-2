<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadGroupsOwnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_groups_owns', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_group_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');

            $table->foreign('lead_group_id')->references('id')->on('lead_groups')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->unique(['owner_id', 'lead_group_id', 'owner_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_groups_owns');
    }
}
