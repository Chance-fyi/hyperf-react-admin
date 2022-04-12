<?php

declare(strict_types=1);

use App\Model\User;
use Hyperf\Database\Seeders\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'admin';
        $user->password = password_hash('admin', PASSWORD_BCRYPT);
        $user->save();
    }
}
