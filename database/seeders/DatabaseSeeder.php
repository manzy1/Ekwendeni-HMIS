<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\HospitalSetting;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ([
            'Super Admin', 'Hospital Administrator', 'Medical Officer/Clinician',
            'Nurse/Midwife', 'FP Provider', 'Data Clerk', 'Pharmacy Staff',
            'Laboratory Staff', 'Accountant', 'Viewer',
        ] as $role) {
            Role::findOrCreate($role);
        }

        HospitalSetting::updateOrCreate(['hospital_name' => 'Ekwendeni Mission Hospital'], [
            'hospital_code' => 'EMH',
            'district' => 'Mzimba',
            'country' => 'Malawi',
            'reporting_year_starts_month' => 4,
            'timezone' => 'Africa/Blantyre',
        ]);

        $admin = User::updateOrCreate(['email' => 'admin@ekwendeni-hmis.test'], [
            'name' => 'HMIS Administrator',
            'password' => Hash::make('ChangeMe123!'),
        ]);
        $admin->syncRoles(['Super Admin']);
    }
}
