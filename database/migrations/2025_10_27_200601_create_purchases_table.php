<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('reference'); // Paymob order or transaction id
            $table->string('email')->nullable(); // for guests
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending | success | failed
            $table->string('feature'); // what they purchased
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
