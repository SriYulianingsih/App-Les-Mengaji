<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrangtuaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            // Tambahkan 'null' => true biar database mengizinkan kolom ini kosong dulu
            'user_id' => ['type' => 'INT', 'unique' => true, 'null' => true],
            'nama_ayah' => ['type' => 'VARCHAR', 'constraint' => 100],
            'nama_ibu' => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 20],
            'email' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true], // Kadang email ortu gak ada, baiknya dinullable
            'pekerjaan_ayah' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'pekerjaan_ibu' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'alamat' => ['type' => 'TEXT'],
            'rt' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true],
            'rw' => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true],
            'kelurahan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kecamatan' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kabupaten' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'provinsi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kode_pos' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orangtua');
    }

    public function down()
    {
        $this->forge->dropTable('orangtua');
    }
}