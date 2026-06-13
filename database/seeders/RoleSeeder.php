<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendefinisikan 5 role utama sistem dengan ID tetap
        $roles = [
            ['id' => 1, 'role_name' => 'petugas'],
            ['id' => 2, 'role_name' => 'verifikator_1'],
            ['id' => 3, 'role_name' => 'verifikator_2'],
            ['id' => 4, 'role_name' => 'eksekutif'],
            ['id' => 5, 'role_name' => 'admin'],
        ];

        foreach ($roles as $r) {
            // Gunakan updateOrCreate berdasarkan ID untuk menghindari duplikasi
            Role::updateOrCreate(
                ['id' => $r['id']],
                ['role_name' => $r['role_name']]
            );
        }
    }
}
