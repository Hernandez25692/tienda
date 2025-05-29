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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio_venta', 10, 2);
            $table->decimal('precio_compra', 10, 2)->nullable(); 
            $table->text('link_compra')->nullable();           
            $table->boolean('disponible')->default(true);        // Agotado = 0 Disponible = 1
            $table->boolean('visible')->default(true);       // Visible = 1 Oculto = 0
             $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
