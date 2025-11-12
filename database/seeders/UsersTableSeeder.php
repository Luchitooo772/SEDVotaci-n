<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $samples = [
           ['dni'=>'12345678','name'=>'Usuario Uno','file'=>'12345678.jpg'],
           ['dni'=>'87654321','name'=>'Usuario Dos','file'=>'87654321.jpg'],
           ['dni'=>'11223344','name'=>'Usuario Tres','file'=>'11223344.jpg'],
        ];

        foreach($samples as $s){
            // Copia manual: coloca los archivos en resources/demo_images/ antes de correr el seeder.
            $src = resource_path('demo_images/'.$s['file']);
            $dst = storage_path('app/public/users/'.$s['file']);
            if(!file_exists(dirname($dst))) mkdir(dirname($dst),0755,true);
            if(file_exists($src) && !file_exists($dst)) copy($src,$dst);

            User::create([
               'name' => $s['name'],
               'email'=> $s['dni'].'@example.test',
               'password' => Hash::make('secret'),
               'dni' => $s['dni'],
               'photo_path' => 'users/'.$s['file'],
            ]);
        }
    }
}
