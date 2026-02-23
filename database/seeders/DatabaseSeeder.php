<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create divisions
        $poliUmum = Division::create(['name' => 'Poli Umum']);
        $poliBidan = Division::create(['name' => 'Poli Bidan']);
        $farmasi = Division::create(['name' => 'Farmasi']);
        $kasir = Division::create(['name' => 'Kasir']);
        $admin = Division::create(['name' => 'Administrasi']);

        // Create roles
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $dokterRole = Role::create(['name' => 'dokter']);
        $bidanRole = Role::create(['name' => 'bidan']);
        $farmasiRole = Role::create(['name' => 'farmasi']);
        $kasirRole = Role::create(['name' => 'kasir']);

        // Super Admin
        $u1 = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'ADM001',
            'division_id' => $admin->id,
            'is_active' => true,
        ]);
        $u1->assignRole($superAdminRole);

        // Admin
        $u2 = User::create([
            'name' => 'Staff Admin',
            'email' => 'staffadmin@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'ADM002',
            'division_id' => $admin->id,
            'is_active' => true,
        ]);
        $u2->assignRole($adminRole);

        // Dokter
        $u3 = User::create([
            'name' => 'Dr. Ahmad Fauzi',
            'email' => 'dokter@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'DOK001',
            'division_id' => $poliUmum->id,
            'is_active' => true,
        ]);
        $u3->assignRole($dokterRole);

        // Bidan
        $u4 = User::create([
            'name' => 'Bd. Siti Nurhaliza',
            'email' => 'bidan@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'BDN001',
            'division_id' => $poliBidan->id,
            'is_active' => true,
        ]);
        $u4->assignRole($bidanRole);

        // Farmasi
        $u5 = User::create([
            'name' => 'Apt. Budi Santoso',
            'email' => 'farmasi@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'FRM001',
            'division_id' => $farmasi->id,
            'is_active' => true,
        ]);
        $u5->assignRole($farmasiRole);

        // Kasir
        $u6 = User::create([
            'name' => 'Rina Wati',
            'email' => 'kasir@polibun.app',
            'password' => Hash::make('password'),
            'nik_karyawan' => 'KSR001',
            'division_id' => $kasir->id,
            'is_active' => true,
        ]);
        $u6->assignRole($kasirRole);
    }
}
