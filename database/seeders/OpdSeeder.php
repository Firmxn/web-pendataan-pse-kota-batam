<?php

namespace Database\Seeders;

use App\Models\Opd;
use Illuminate\Database\Seeder;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opds = [
            ['name' => 'Dinas Komunikasi dan Informatika', 'type' => 'Dinas', 'email' => 'diskominfo@example.go.id'],
            ['name' => 'Dinas Pendidikan', 'type' => 'Dinas', 'email' => 'disdik@example.go.id'],
            ['name' => 'Dinas Kesehatan', 'type' => 'Dinas', 'email' => 'dinkes@example.go.id'],
            ['name' => 'Dinas Pekerjaan Umum dan Penataan Ruang', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Perhubungan', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Sosial', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Tenaga Kerja', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Koperasi, Usaha Kecil dan Menengah', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Pariwisata', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Pemuda dan Olahraga', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Perpustakaan dan Kearsipan', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Lingkungan Hidup', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Pemberdayaan Perempuan dan Perlindungan Anak', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Kependudukan dan Pencatatan Sipil', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Dinas Perumahan Rakyat dan Kawasan Permukiman', 'type' => 'Dinas', 'email' => null],
            ['name' => 'Satuan Polisi Pamong Praja', 'type' => 'Satuan', 'email' => null],
            ['name' => 'Badan Perencanaan Pembangunan Daerah', 'type' => 'Badan', 'email' => null],
            ['name' => 'Badan Pengelolaan Keuangan dan Aset Daerah', 'type' => 'Badan', 'email' => null],
            ['name' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'type' => 'Badan', 'email' => null],
            ['name' => 'Badan Pendapatan Daerah', 'type' => 'Badan', 'email' => null],
            ['name' => 'Badan Penanggulangan Bencana Daerah', 'type' => 'Badan', 'email' => null],
            ['name' => 'Badan Kesatuan Bangsa dan Politik', 'type' => 'Badan', 'email' => null],
            ['name' => 'Sekretariat Daerah', 'type' => 'Sekretariat', 'email' => null],
            ['name' => 'Sekretariat DPRD', 'type' => 'Sekretariat', 'email' => null],
            ['name' => 'Inspektorat', 'type' => 'Inspektorat', 'email' => null],
            ['name' => 'Kecamatan Batam Kota', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Sekupang', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Sagulung', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Bengkong', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Batu Aji', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Nongsa', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Lubuk Baja', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Sei Beduk', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Bulang', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Galang', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Belakang Padang', 'type' => 'Kecamatan', 'email' => null],
            ['name' => 'Kecamatan Batu Ampar', 'type' => 'Kecamatan', 'email' => null],
        ];

        foreach ($opds as $opd) {
            Opd::updateOrCreate(
                [
                    'name' => $opd['name'],
                    'type' => $opd['type'],
                    'email' => $opd['email']
                ],
            );
        }
    }
}
