<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // List of admin accounts (expand anytime)
        $admins = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'phone' => '9999999999',
                'clinic_name' => 'Head Office',
                'ward_id' => null, // admin doesn't belong to ward
                'internet_status' => 'active',
                'internet_speed' => 'Unlimited',
                'bandwidth' => 'Unlimited',
                'password' => 'admin123',
            ],
        ];

        foreach ($admins as $adminData) {

            $admin = User::firstOrCreate(
                ['email' => $adminData['email']],
                [
                    'name'            => $adminData['name'],
                    'phone'           => $adminData['phone'],
                    'clinic_name'     => $adminData['clinic_name'],
                    'ward_id'         => $adminData['ward_id'],
                    'internet_status' => $adminData['internet_status'],
                    'internet_speed'  => $adminData['internet_speed'],
                    'bandwidth'       => $adminData['bandwidth'],
                    'password'        => Hash::make($adminData['password']),
                ]
            );
        
            if (!$admin->hasRole('admin')) {
                $admin->assignRole($adminRole);
            }
        }

        echo "Admin Seeder executed successfully.\n";
    }
}
