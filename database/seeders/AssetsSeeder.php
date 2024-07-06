<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aset Fisik 1
        DB::table('assets')->insert([
            'tipe_aset' => 'fisik',
            'kode_aset' => 'FS-001',
            'nama_aset' => 'Server Rack',
            'harga' => 5000000,
            'spesifikasi' => 'Ukuran 42U, Warna Hitam',
            'keterangan' => 'Rak untuk menempatkan server',
            'stok_awal' => 10,
            'stok_sekarang' => 10,
            'masa_berlaku' => now()->addYears(5),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Fisik 2
        DB::table('assets')->insert([
            'tipe_aset' => 'fisik',
            'kode_aset' => 'FS-002',
            'nama_aset' => 'Server Hardware',
            'harga' => 20000000,
            'spesifikasi' => 'Intel Xeon, 64GB RAM, 4TB HDD',
            'keterangan' => 'Server utama',
            'stok_awal' => 5,
            'stok_sekarang' => 5,
            'masa_berlaku' => now()->addYears(5),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Fisik 3
        DB::table('assets')->insert([
            'tipe_aset' => 'fisik',
            'kode_aset' => 'FS-003',
            'nama_aset' => 'Network Switch',
            'harga' => 1000000,
            'spesifikasi' => '24-Port Gigabit Ethernet',
            'keterangan' => 'Switch jaringan',
            'stok_awal' => 20,
            'stok_sekarang' => 20,
            'masa_berlaku' => now()->addYears(5),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Fisik 4
        DB::table('assets')->insert([
            'tipe_aset' => 'fisik',
            'kode_aset' => 'FS-004',
            'nama_aset' => 'Firewall',
            'harga' => 8000000,
            'spesifikasi' => 'Firewall perangkat keras',
            'keterangan' => 'Perlindungan jaringan',
            'stok_awal' => 3,
            'stok_sekarang' => 3,
            'masa_berlaku' => now()->addYears(5),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Fisik 5
        DB::table('assets')->insert([
            'tipe_aset' => 'fisik',
            'kode_aset' => 'FS-005',
            'nama_aset' => 'Load Balancer',
            'harga' => 6000000,
            'spesifikasi' => 'Load balancer perangkat keras',
            'keterangan' => 'Distribusi beban jaringan',
            'stok_awal' => 2,
            'stok_sekarang' => 2,
            'masa_berlaku' => now()->addYears(5),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Layanan 1
        DB::table('assets')->insert([
            'tipe_aset' => 'layanan',
            'kode_aset' => 'LY-001',
            'nama_aset' => 'Web Server',
            'harga' => 1500000,
            'spesifikasi' => 'Apache/Nginx',
            'keterangan' => 'Layanan server web',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Layanan 2
        DB::table('assets')->insert([
            'tipe_aset' => 'layanan',
            'kode_aset' => 'LY-002',
            'nama_aset' => 'Database Server',
            'harga' => 2000000,
            'spesifikasi' => 'MySQL/PostgreSQL',
            'keterangan' => 'Layanan server database',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Layanan 3
        DB::table('assets')->insert([
            'tipe_aset' => 'layanan',
            'kode_aset' => 'LY-003',
            'nama_aset' => 'Monitoring Server',
            'harga' => 1800000,
            'spesifikasi' => 'Nagios/Zabbix',
            'keterangan' => 'Layanan monitoring',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Layanan 4
        DB::table('assets')->insert([
            'tipe_aset' => 'layanan',
            'kode_aset' => 'LY-004',
            'nama_aset' => 'Email Server',
            'harga' => 1700000,
            'spesifikasi' => 'Postfix/Sendmail',
            'keterangan' => 'Layanan email server',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Layanan 5
        DB::table('assets')->insert([
            'tipe_aset' => 'layanan',
            'kode_aset' => 'LY-005',
            'nama_aset' => 'File Server',
            'harga' => 1600000,
            'spesifikasi' => 'FTP/SFTP',
            'keterangan' => 'Layanan file server',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Digital 1
        DB::table('assets')->insert([
            'tipe_aset' => 'digital',
            'kode_aset' => 'DG-001',
            'nama_aset' => 'Website',
            'harga' => 3000000,
            'spesifikasi' => 'Platform: WordPress, Tema: Custom',
            'keterangan' => 'Website utama perusahaan',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Digital 2
        DB::table('assets')->insert([
            'tipe_aset' => 'digital',
            'kode_aset' => 'DG-002',
            'nama_aset' => 'CRM System',
            'harga' => 5000000,
            'spesifikasi' => 'Platform: Salesforce',
            'keterangan' => 'Sistem manajemen hubungan pelanggan',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Digital 3
        DB::table('assets')->insert([
            'tipe_aset' => 'digital',
            'kode_aset' => 'DG-003',
            'nama_aset' => 'VPS',
            'harga' => 4000000,
            'spesifikasi' => 'VPS 2gb CPU',
            'keterangan' => 'VPS',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Digital 4
        DB::table('assets')->insert([
            'tipe_aset' => 'digital',
            'kode_aset' => 'DG-004',
            'nama_aset' => 'Cloud Storage',
            'harga' => 2000000,
            'spesifikasi' => 'Platform: AWS S3',
            'keterangan' => 'Layanan penyimpanan cloud',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aset Digital 5
        DB::table('assets')->insert([
            'tipe_aset' => 'digital',
            'kode_aset' => 'DG-005',
            'nama_aset' => 'Antivirus Software',
            'harga' => 1000000,
            'spesifikasi' => 'Platform: Kaspersky',
            'keterangan' => 'Perlindungan antivirus untuk jaringan',
            'stok_awal' => 1,
            'stok_sekarang' => 1,
            'masa_berlaku' => now()->addYears(2),
            'tanggal_penerimaan' => now(),
            'status_aset' => 1,
            'kondisi_aset' => 1,
            'lokasi_aset' => 1,
            'pemilik_aset' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
