<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create( 'todos', function ( Blueprint $table ) {
            $table->id();

            // Relationsip
            $table->foreignId( 'user_id' )
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            // Nomal Field
            $table->string( 'title' );
            $table->string( 'exp_date' );
            $table->string( 'exp_time' );
            $table->text( 'description' )->nullable();
            $table->boolean( 'completed' )->default( false );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists( 'todos' );
    }
};
