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
        Schema::create('scheduled_sms', function (Blueprint $table) {
            $table->id();
            $table->string('contact_air_id');
            $table->text('message');
            $table->timestamp('scheduled_at');
            $table->timestamps();

            $table->foreign('contact_air_id')
                ->references('air_id')
                ->on('contacts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_sms');
    }
};
