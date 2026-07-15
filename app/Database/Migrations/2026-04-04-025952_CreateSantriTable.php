<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSantriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'orangtua_id' => ['type' => 'INT'],
            'nis' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
            'tempat_lahir' => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_lahir' => ['type' => 'DATE'],
            'alamat' => ['type' => 'TEXT'],
            'pendidikan_terakhir' => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_daftar' => ['type' => 'DATE'],
            'kelas' => ['type' => 'VARCHAR', 'constraint' => 50],
            'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif', 'lulus']],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('orangtua_id', 'orangtua', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('santri');
    }

    public function down()
    {
        $this->forge->dropTable('santri');
    }
}
