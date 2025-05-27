<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // cliente que hace el pedido
            $table->decimal('total', 10, 2)->default(0);
            $table->string('estado')->default('pendiente'); // pendiente, confirmado, entregado, cancelado
            $table->date('fecha_entrega_estimada')->nullable();
            $table->string('comprobante')->nullable(); // archivo opcional
            $table->string('codigo')->nullable()->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
