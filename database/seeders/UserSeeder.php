<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JuryBoard;
use App\Models\SuperStar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
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
        $user->category_id = 1;
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
        $user->user_type = 'user';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        $user = new User();
        $user->first_name = 'Mr.';
        $user->last_name = 'Jury';
        $user->email = 'jury@gmail.com';
        $user->image = null;
        $user->cover_photo = 'uploads/images/users/1642659396.jpg';
        $user->phone = '01700000010';
        $user->password = Hash::make('12345');
        $user->user_type = 'jury';
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // audition-admin
        for ($i=1; $i < 11; $i++) {
            $user = new User();
            $user->first_name = 'Mr. Audition';
            $user->last_name = 'Admin '.$i;
            $user->email = 'audition-admin'.$i.'@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '016000000'.$i;
            $user->password = Hash::make('12345');
            $user->user_type = 'audition-admin';
            // $user->status = $faker->numberBetween(0, 1);
            $user->status = 1;
            // $user->category_id = $faker->numberBetween(1, 8);
            $user->category_id = 1;
            $user->otp = '123456';
            $user->save();
        }


        // jury
        for ($i=1; $i < 11; $i++) {
            $user = new User();
            $user->first_name = 'Mr. ';
            $user->last_name = 'Jury '.$i;
            $user->email = 'jury'.$i.'@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '016110000'.$i;
            $user->password = Hash::make('12345');
            $user->user_type = 'jury';
            $user->status = 1;
            // $user->status = $faker->numberBetween(0, 1);
            // $user->category_id = $faker->numberBetween(1, 8);
            $user->category_id = 1;
            $user->otp = '123456';
            $user->save();

            $jury = new JuryBoard();
            $jury->star_id =  $user->id;
            $jury->manager_admin_id =  $user->id;
            $jury->category_id = 1;
            $jury->terms_and_condition = $faker->text;
            $jury->description = $faker->text;
            $jury->qr_code = $faker->numberBetween(100000, 999999);
            $jury->save();
        }
        // star against 1st category (soprts)
        for ($i=1; $i < 11; $i++) {
            $user = new User();
            $user->first_name = 'Star '.$i;
            $user->last_name = '(Sports)';
            $user->email = 'star'.$i.'sports@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '011000000'.$i;
            $user->category_id = 1;
            $user->password = Hash::make('12345');
            $user->user_type = 'star';
            $user->status = 1;
            $user->otp = '123456';
            $user->save();
        }


        // judge
        for ($i=1; $i < 11; $i++) {
            $user = new User();
            $user->first_name = 'Mr. ';
            $user->last_name = 'Judge '.$i;
            $user->email = 'judge'.$i.'@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '016110022'.$i;
            $user->password = Hash::make('12345');
            $user->user_type = 'star';
            $user->status = 1;
            // $user->status = $faker->numberBetween(0, 1);
            // $user->category_id = $faker->numberBetween(1, 8);
            $user->category_id = 1;
            $user->otp = '123456';
            $user->save();

            $star = new SuperStar();

            $star->star_id = $user->id;
            $star->admin_id = 1;
            $star->category_id = 1;
            // $star->sub_category_id = $request->input('subcategory_id');
            $star->terms_and_condition =  $faker->text;
            $star->qr_code = rand( 10000000 , 99999999 );
            $star->save();
        }

        for ($i=2; $i < 7; $i++) {
            $user = new User();
            $user->first_name = 'Mr.';
            $user->last_name = 'User '.$i;
            $user->email = 'user'.$i.'@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '017001000'.$i;
            $user->password = Hash::make('12345');
            $user->user_type = 'user';
            $user->status = 1;
            $user->otp = '123456';
            $user->save();
        }
    }
}
