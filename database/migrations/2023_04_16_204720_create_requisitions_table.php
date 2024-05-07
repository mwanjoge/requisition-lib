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
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('requisable');
            $table->integer('requested_by')->unsigned();
            $table->dateTime('issued_at');
            $table->string('reference_no')->nullable();
            $table->string('status')->nullable();
            $table->decimal('total_amount',20,2)->default(0);
            $table->string('description')->nullable();
            $table->string('currency')->nullable();
            $table->json('currency_pair')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('requisitions');
    }
};
