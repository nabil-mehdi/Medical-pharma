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
    public function up(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->string('nom_pharmacie')->after('user_id');
            $table->string('adresse')->after('nom_pharmacie');
            $table->boolean('ouvert')->default(false)->after('adresse');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn('ouvert_ou_en_garde');
        });
    }
};
