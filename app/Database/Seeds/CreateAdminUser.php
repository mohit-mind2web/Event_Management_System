<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use App\Models\UserModel;

class CreateAdminUser extends Seeder
{
    public function run()
    {
        $users = new UserModel();
        $email = 'admin@example.com';

        $user = $users->findByCredentials(['email' => $email]);

        if ($user) {
            echo "User with email {$email} already exists.\n";
            return;
        }

        $user = new User([
            'username'  => 'admin',
            'email'     => $email,
            'password'  => 'password123',
            'full_name' => 'Super Admin',
            'active'    => true,
        ]);

        $users->save($user);

        // Fetch user to get ID and assign group
        $user = $users->findById($users->getInsertID());

        if ($user) {
            $user->addGroup('admin');
            echo "Admin user created successfully.\n";
            echo "Email: {$email}\n";
            echo "Password: password123\n";
        }
    }
}
