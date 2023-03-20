<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type');
            $table->string('address')->fulltext();
            $table->integer('size');
            $table->integer('bedrooms');
            $table->decimal('price',12,2);
            $table->decimal('latitude',8,2);
            $table->decimal('longitude',8,2);
            $table->timestamps();

            $table->index(['size','bedrooms']);
            $table->index(['latitude','longitude']);

            $table->foreign('id_type')->references('id')->on('unit_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
