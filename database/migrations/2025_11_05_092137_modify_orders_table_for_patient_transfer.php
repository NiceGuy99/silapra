<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the existing orders table
        Schema::dropIfExists('orders');
        
        // Create new orders table with updated structure
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rm');
            $table->string('nama_pasien');
            $table->string('asal_ruangan_mutasi');
            $table->string('tujuan_ruangan_mutasi');
            $table->string('user_request');
            $table->string('asal_ruangan_user_request');
            $table->timestamp('tanggal_permintaan')->nullable();
            $table->timestamp('tanggal_diterima')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->enum('status', ['pending', 'process', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop the new orders table
        Schema::dropIfExists('orders');
        
        // Recreate the original orders table
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('product');
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }
};
