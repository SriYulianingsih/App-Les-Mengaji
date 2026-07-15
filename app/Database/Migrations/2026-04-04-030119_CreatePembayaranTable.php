<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePembayaranTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'auto_increment' => true],
            'santri_id' => ['type' => 'INT'],
            'bulan' => ['type' => 'INT'],
            'tahun' => ['type' => 'INT'],
            'jumlah_bayar' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'status' => ['type' => 'ENUM', 'constraint' => ['lunas', 'belum']],
            'metode_pembayaran' => ['type' => 'ENUM', 'constraint' => ['cash', 'transfer']],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
            'tanggal_bayar' => ['type' => 'DATE', 'null' => true],
            'bukti_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['santri_id', 'bulan', 'tahun']);
        $this->forge->addForeignKey('santri_id', 'santri', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}
