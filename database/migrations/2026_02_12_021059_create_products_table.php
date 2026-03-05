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
        // Membuat tabel products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->integer('harga');
            $table->integer('stok');
            $table->boolean('tersedia')->default(true);
            $table->string('file_foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Menambahkan kolom barcode
        Schema::table('products', function (Blueprint $table) {
            $table->string('barcode')->index()->after('nama');
        });

        // Mengganti nama kolom file_foto menjadi image
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('file_foto', 'image');
        });

        // Mengubah tipe data harga
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan tipe harga
        Schema::table('products', function (Blueprint $table) {
            $table->integer('harga')->change();
        });

        // Mengembalikan nama kolom image menjadi file_foto
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('image', 'file_foto');
        });

        // Menghapus kolom barcode
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('barcode');
        });

        // Menghapus tabel products
        Schema::dropIfExists('products');
    }
};