<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @see \Laragear\WebAuthn\Models\WebAuthnCredential
 */
return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('wassenger_history', static function (Blueprint $table): void {
            static::defaultBlueprint($table);

            // You may add here your own columns...
            //
            // $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('wassenger_history');
    }

    /**
     * Generate the default blueprint for the WebAuthn credentials table.
     *
     * @param  \Illuminate\Database\Schema\Blueprint  $table
     * @return void
     */
    protected static function defaultBlueprint(Blueprint $table): void
    {
        $table->string('id')->primary();

      //UPcoming Creating table to store histories
        $table->timestamps();
    }
};
