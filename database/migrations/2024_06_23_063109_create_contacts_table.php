<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Schema::table(namaTable, callback) --> alter table, merubah table
    // Schema::create(namaTable, callback) --> membuat tabel baru, method pada callback:
    // tipeData('namaKolom', size)
    // nullable(condition)
    // primary()
    // default(value)
    // useCurrent()
    // unique() --> memastikan value unique, tidak ada value yang sama
    // foreign(namaKolom)->refferences(kolomReferensi)->on(tableReferensi)

    // Run the migrations.
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 100)->nullable(false);
            $table->string("last_name", 100)->nullable();
            $table->string("email", 200)->nullable();
            $table->string("phone", 20)->nullable();
            $table->unsignedBigInteger("user_id")->nullable(false);
            $table->timestamps();

            $table->foreign("user_id")->on("users")->references("id");
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
