<?php

use App\Models\Argument;
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
        Schema::create('judgements', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid("argument_ulid")->constrained("arguments", "ulid")->cascadeOnDelete();
            $table->text("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judgements');
    }
};
