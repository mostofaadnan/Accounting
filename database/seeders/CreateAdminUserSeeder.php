<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
        	'name' => 'admin', 
        	'email' => 'vsoft1989@gmail.com',
            'password' => bcrypt('12345678'),
            'status'=>'1',
            'image'=>'1603042204png'
        ]);
  
    }
}
