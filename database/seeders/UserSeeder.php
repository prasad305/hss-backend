<?php

namespace Database\Seeders;

use App\Models\SuperStar;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\New_;

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
        $user->first_name = 'Mr. Super';
        $user->last_name = ' Admin';
        $user->email = 'superadmin@gmail.com';
        $user->phone = '01700000000';
        $user->password = Hash::make('12345');
        $user->user_type = 'super-admin'; // SUPER Admin user_type == 'super-admin'
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Manager Admin ';
        $user->last_name = ' (sports)';
        $user->email = 'manager-admin-sports@gmail.com';
        $user->phone = '01700000001';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Shakib';
        $user->last_name = 'Al Hasan';
        $user->email = 'shakib75@gmail.com';
        $user->image = '';
        $user->phone = '01700000003';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        $user = new User();
        $user->first_name = 'Mizanur Rahman';
        $user->last_name = 'Raihan';
        $user->email = 'raihan@gmail.com';
        $user->phone = '01700000002';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin'; // Admin user_type == 'admin'
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        $user = new User();
        $user->first_name = 'Mizanur Rahman';
        $user->last_name = 'Azhari';
        $user->email = 'azhari@gmail.com';
        $user->image = 'uploads/images/users/1642919728.jpg';
        $user->phone = '01700000004';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Momtaz';
        $user->last_name = 'Begum';
        $user->email = 'momtaj@gmail.com';
        $user->image = 'uploads/images/users/Momtaz-Begum-photo.jpg';
        $user->phone = '01700000005';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Srabanti';
        $user->last_name = 'Chatterjee';
        $user->email = 'star-movie@gmail.com';
        $user->image = 'uploads/images/users/srabanti.jpg';
        $user->phone = '01700000006';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Tamim';
        $user->last_name = 'Hasan';
        $user->email = 'cricket3-movie@gmail.com';
        $user->image = 'uploads/images/star/tamim.png';
        $user->phone = '01700000007';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Musfiq';
        $user->last_name = 'Hasan';
        $user->email = 'cricket5-movie@gmail.com';
        $user->image = 'uploads/images/star/musfiqur.png';
        $user->phone = '01700000008';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->first_name = 'Mr.';
        $user->last_name = 'User';
        $user->email = 'user1@gmail.com';
        $user->image = 'uploads/images/users/lzg-1643882523.jpg';
        $user->cover_photo = 'uploads/images/users/1642659396.jpg';
        $user->phone = '01700000009';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

    }
}
