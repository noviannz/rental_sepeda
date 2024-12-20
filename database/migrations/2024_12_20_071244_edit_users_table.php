<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->after('password')->default('user');
            $table->string('plain_token');// Tambahkan kolom baru
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan jika migrasi di-rollback
            $table->dropColumn('role');

            // Kembalikan perubahan pada kolom yang diubah (jika perlu)
            $table->string('name')->nullable(false)->change();
        });
    }
}
