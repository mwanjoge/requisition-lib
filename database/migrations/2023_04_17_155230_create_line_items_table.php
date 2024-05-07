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
        Schema::create('line_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained();
            $table->nullableMorphs('lineable');
            $table->string('name')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->decimal('unit_amount')->unsigned()->default(0);
            $table->decimal('sub_total_amount')->unsigned()->default(0);
            $table->string('currency')->nullable();
            $table->json('currency_pair')->nullable();
            $table->string('description')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('unit')->nullable();
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
        Schema::drop('line_items');
    }
};
