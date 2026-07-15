<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            // 1. Tambahkan 'null' => true dan hilangkan 'unique' => true di sini
            'user_id' => ['type' => 'INT', 'null' => true], 
            'nip' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true], // NIP sebaiknya unik agar tidak kembar
            'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
            'jenis_kelamin' => ['type' => 'VARCHAR', 'constraint' => 10],
            'no_hp' => ['type' => 'VARCHAR', 'constraint' => 20],
            'alamat' => ['type' => 'TEXT'],
            'pendidikan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'foto' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        
        // Tetap pasang foreign key agar terelasi ke tabel users
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}