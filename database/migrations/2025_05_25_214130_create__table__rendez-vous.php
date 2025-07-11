<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('RendezVous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');

            // On choisit un professionnel (medecin ou infirmier)
            $table->enum('type', ['medecin', 'infirmier']);
            $table->foreignId('professionnel_id')->constrained('users')->onDelete('cascade');

            $table->date('date');
            $table->time('heure');
            $table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('RendezVous', function (Blueprint $table) {
            //
        });
    }
};
