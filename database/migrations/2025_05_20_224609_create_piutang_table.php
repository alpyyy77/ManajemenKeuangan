<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutangTable extends Migration
{
    public function up(): void
    {
        Schema::create('piutang', function (Blueprint $table) {
            $table->id('id_piutang');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->string('debitur');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piutang');
    }
}
