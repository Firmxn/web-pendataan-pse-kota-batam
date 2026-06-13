<?php

namespace Database\Seeders;

use App\Models\Opd;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role dari database
        $roleVerifikator1 = Role::where('role_name', 'verifikator_1')->first();
        $roleVerifikator2 = Role::where('role_name', 'verifikator_2')->first();
        $rolePetugas = Role::where('role_name', 'petugas')->first();
        $roleEksekutif = Role::where('role_name', 'eksekutif')->first();
        $roleAdmin = Role::where('role_name', 'admin')->first();

        // Ambil beberapa OPD untuk petugas
        $opdDiskominfo = Opd::where('name', 'Dinas Komunikasi dan Informatika')->first();

        // User Admin
        User::updateOrCreate(
            ['email' => 'admin@example.go.id'],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440005', // Gunakan suffix 05 untuk Admin (ID 5)
                'name' => 'Administrator Utama',
                'role_id' => $roleAdmin->id,
                'opd_id' => null,
                'phone' => '6281234567805',
                'nip' => '198505052010015005',
                'position' => 'Super Administrator',
                'status' => 'active',
                'work_unit' => 'Pusat Data Diskominfo',
                'work_unit_phone' => '62778123456',
            ]
        );

        // User Eksekutif
        User::updateOrCreate(
            ['email' => 'eksekutif@example.go.id'],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440004', // Gunakan suffix 04 untuk Eksekutif (ID 4)
                'name' => 'Eksekutif Pimpinan',
                'role_id' => $roleEksekutif->id,
                'opd_id' => null,
                'phone' => '6281234567804',
                'nip' => '198504042010014004',
                'position' => 'Pimpinan Monitoring',
                'status' => 'active',
                'work_unit' => 'Sekretariat Daerah',
                'work_unit_phone' => '62778123456',
            ]
        );

        // User Verifikator 1
        User::updateOrCreate(
            ['email' => 'verifikator1@example.go.id'],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440001',
                'name' => 'Verifikator Tingkat 1',
                'role_id' => $roleVerifikator1->id,
                'opd_id' => null,
                'phone' => '6281234567801',
                'nip' => '198501012010011001',
                'position' => 'Verifikator Tingkat 1',
                'status' => 'active',
                'work_unit' => 'Diskominfo Kota Batam',
                'work_unit_phone' => '62778123456',
            ]
        );

        // User Verifikator 2
        User::updateOrCreate(
            ['email' => 'verifikator2@example.go.id'],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440002',
                'name' => 'Verifikator Tingkat 2',
                'role_id' => $roleVerifikator2->id,
                'opd_id' => null,
                'phone' => '6281234567802',
                'nip' => '198502022010012002',
                'position' => 'Verifikator Tingkat 2',
                'status' => 'active',
                'work_unit' => 'Diskominfo Kota Batam',
                'work_unit_phone' => '62778123456',
            ]
        );

        // User Petugas - Diskominfo
        User::updateOrCreate(
            ['email' => 'petugas@example.go.id'],
            [
                'uuid' => '550e8400-e29b-41d4-a716-446655440003',
                'name' => 'Petugas Diskominfo',
                'role_id' => $rolePetugas->id,
                'opd_id' => $opdDiskominfo->id,
                'phone' => '6281234567803',
                'nip' => '198503032010013003',
                'position' => 'Staf IT',
                'status' => 'active',
                'work_unit' => 'Bidang Aplikasi dan Informatika',
                'work_unit_phone' => '62778123456',
            ]
        );
    }
}
