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
        Schema::create('audit_logs', function (Blueprint $table) {
        $table->id('audit_logs_id');
        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('actor_name');
        $table->string('action_type')->index();
        $table->nullableMorphs('auditable'); // auditable_type + auditable_id (no FK needed)
        $table->text('details');
        $table->json('old_values')->nullable();
        $table->json('new_values')->nullable();
        $table->timestamp('created_at')->useCurrent()->index();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
