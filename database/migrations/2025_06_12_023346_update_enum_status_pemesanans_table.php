<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnumStatusPemesanansTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE pemesanans MODIFY status ENUM('dipesan', 'checkin', 'checkout', 'dibersihkan') NOT NULL");
    }

    public function down()
    {
        // Kembalikan ke enum lama jika perlu
        DB::statement("ALTER TABLE pemesanans MODIFY status ENUM('dipesan', 'checkin', 'checkout') NOT NULL");
    }
}
