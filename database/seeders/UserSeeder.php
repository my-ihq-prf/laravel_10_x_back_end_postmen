<?php /** @noinspection SpellCheckingInspection */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminEmail = 'admin@example.com';
        User::factory()->create([
            'name' => 'admin',
            'email' => $adminEmail,
            // $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
            'password' => Hash::make('password'),
        ]);
        User::factory(10)->create();


        foreach (User::all() as $user) {
            if ($user->getAttribute('email') === $adminEmail) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('standard');
            }
        }
    }
}
