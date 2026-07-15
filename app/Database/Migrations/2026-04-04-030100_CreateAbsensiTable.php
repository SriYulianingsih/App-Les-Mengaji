<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'santri_id' => ['type' => 'INT'],
            'jadwal_id' => ['type' => 'INT'],
            'tanggal' => ['type' => 'DATE'],
            'status' => ['type' => 'ENUM', 'constraint' => ['hadir', 'izin', 'sakit', 'alpha']],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['santri_id', 'jadwal_id', 'tanggal']);
        $this->forge->addForeignKey('santri_id', 'santri', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jadwal_id', 'jadwal', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
