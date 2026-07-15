<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'jenis_laporan' => ['type' => 'ENUM', 'constraint' => ['absensi', 'pembayaran']],
            'periode_bulan' => ['type' => 'INT'],
            'periode_tahun' => ['type' => 'INT'],
            'tanggal_cetak' => ['type' => 'DATE'],
            'user_id' => ['type' => 'INT'],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('laporan');
    }

    public function down()
    {
        $this->forge->dropTable('laporan');
    }
}
