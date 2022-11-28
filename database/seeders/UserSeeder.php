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
        // for super admin user
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Mr. Super';
        $user->last_name = ' Admin';
        $user->email = 'superadmin@gmail.com';
        $user->phone = '01700000000';
        $user->password = Hash::make('12345');
        $user->user_type = 'super-admin'; // SUPER Admin user_type == 'super-admin'
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for Manager Admin User
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = ' (Flim Stars)';
        $user->email = 'flim-stars@gmail.com';
        $user->phone = '01700000001';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = ' (sports)';
        $user->email = 'sports@gmail.com';
        $user->phone = '01700000002';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 2;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(musicians)';
        $user->email = 'musicians@gmail.com';
        $user->phone = '01700000003';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 3;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(drama)';
        $user->email = 'drama@gmail.com';
        $user->phone = '01700000005';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 5;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(tech)';
        $user->email = 'tech@gmail.com';
        $user->phone = '01700000006';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 6;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(motivational-speaker)';
        $user->email = 'motivational-speaker@gmail.com';
        $user->phone = '01700000007';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 7;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(religion)';
        $user->email = 'religiion@gmail.com';
        $user->phone = '01700000008';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 8;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(comedians)';
        $user->email = 'comedians@gmail.com';
        $user->phone = '01700000009';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 9;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Manager Admin ';
        $user->last_name = '(social)';
        $user->email = 'social@gmail.com';
        $user->phone = '01700000010';
        $user->password = Hash::make('12345');
        $user->user_type = 'manager-admin'; // Manager Admin user_type == 'manager-admin'
        $user->status = 1;
        $user->category_id = 10;
        $user->otp = '123456';
        $user->save();

        // superstar admin

        // For Super Star | Category Flim Star
        // bollywood category 
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Akshay ';
        $user->last_name = 'Admin';
        $user->email = 'akshayadmin@gmail.com';
        $user->image = null;
        $user->phone = '01712000011';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Sanjay ';
        $user->last_name = 'Admin';
        $user->email = 'sanjayadmin@gmail.com';
        $user->image = null;
        $user->phone = '01713000012';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shah Rukh ';
        $user->last_name = 'Admin';
        $user->email = 'shahrukhkahnadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171002013';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for Tallywood Star

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Srabanti ';
        $user->last_name = 'Admin';
        $user->email = 'srabantiadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171070014';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Rituparna ';
        $user->last_name = 'Admin';
        $user->email = 'rituparnaadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171040015';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Jeet ';
        $user->last_name = 'Admin';
        $user->email = 'jeetadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171600016';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for Dhallywood Star

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shakib  ';
        $user->last_name = 'Admin';
        $user->email = 'shakib-khanadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171008017';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Ferdous ';
        $user->last_name = 'Admin';
        $user->email = 'ferdousadmin@gmail.com';
        $user->image = null;
        $user->phone = '0171040018';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Purnima ';
        $user->last_name = 'Admin';
        $user->email = 'purnimaadmin@gmail.com';
        $user->image = null;
        $user->phone = '01715005019';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // For Sports Category 

        // for cricket admin
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shakib';
        $user->last_name = 'Admin';
        $user->email = 'shakib75admin@gmail.com';
        $user->image = null;
        $user->phone = '01713000020';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Mushfiqur ';
        $user->last_name = 'Admin';
        $user->email = 'mushfiqadmin@gmail.com';
        $user->image = null;
        $user->phone = '01716000021';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Tamim ';
        $user->last_name = 'Admin';
        $user->email = 'tamimadmin@gmail.com';
        $user->image = null;
        $user->phone = '01715000022';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for football admin

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Messi ';
        $user->last_name = 'Admin';
        $user->email = 'messiadmin@gmail.com';
        $user->image = null;
        $user->phone = '01714000030';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Neymar ';
        $user->last_name = 'Admin';
        $user->email = 'neymaradmin@gmail.com';
        $user->image = null;
        $user->phone = '01711000023';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Ronaldo ';
        $user->last_name = 'Admin';
        $user->email = 'ronaldoadmin@gmail.com';
        $user->image = null;
        $user->phone = '01716000024';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        //  Musician Category

        // for Folk Music
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Momtaz';
        $user->last_name = 'Admin';
        $user->email = 'momtajadmin@gmail.com';
        $user->image = 'uploads/images/users/Momtaz-Begum-photo.jpg';
        $user->phone = '01717000025';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 3;
        $user->sub_category_id = 7;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for rock music
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'James';
        $user->last_name = 'Admin';
        $user->email = 'jamesadmin@gmail.com';
        $user->image = null;
        $user->phone = '01718000026';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 3;
        $user->sub_category_id = 8;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Chirkutt';
        $user->last_name = 'Admin';
        $user->email = 'chirkuttadmin@gmail.com';
        $user->image = null;
        $user->phone = '01719000027';
        $user->password = Hash::make('12345');
        $user->user_type = 'admin';
        $user->category_id = 3;
        $user->sub_category_id = 8;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();



        // For Super Star | Category Flim Star
        // bollywood category 
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Akshay ';
        $user->last_name = 'Kumar';
        $user->email = 'akshay@gmail.com';
        $user->image = null;
        $user->phone = '01700000011';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 11;
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Sanjay ';
        $user->last_name = 'Dutt';
        $user->email = 'sanjay@gmail.com';
        $user->image = null;
        $user->phone = '01700000012';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 12;
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shah Rukh ';
        $user->last_name = 'Khan';
        $user->email = 'shahrukhkahn@gmail.com';
        $user->image = null;
        $user->phone = '01700000013';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 13;
        $user->category_id = 1;
        $user->sub_category_id = 1;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for Tallywood Star

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Srabanti ';
        $user->last_name = 'Chatterjee';
        $user->email = 'srabanti@gmail.com';
        $user->image = null;
        $user->phone = '01700000014';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 14;
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Rituparna ';
        $user->last_name = 'Sengupta';
        $user->email = 'rituparna@gmail.com';
        $user->image = null;
        $user->phone = '01700000015';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 15;
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Jeet ';
        $user->last_name = ' ';
        $user->email = 'jeet@gmail.com';
        $user->image = null;
        $user->phone = '01700000016';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 16;
        $user->category_id = 1;
        $user->sub_category_id = 3;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for Dhallywood Star

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shakib  ';
        $user->last_name = 'Khan';
        $user->email = 'shakib-khan@gmail.com';
        $user->image = null;
        $user->phone = '01700000017';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 17;
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Ferdous ';
        $user->last_name = 'Ahmed';
        $user->email = 'ferdous@gmail.com';
        $user->image = null;
        $user->phone = '01700000018';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 18;
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Purnima ';
        $user->last_name = ' ';
        $user->email = 'purnima@gmail.com';
        $user->image = null;
        $user->phone = '01700000019';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 19;
        $user->category_id = 1;
        $user->sub_category_id = 2;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // For Sports Category 

        // for cricket star
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Shakib';
        $user->last_name = 'Al Hasan';
        $user->email = 'shakib75@gmail.com';
        $user->image = null;
        $user->phone = '01700000020';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 20;
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Mushfiqur ';
        $user->last_name = 'Rahim';
        $user->email = 'mushfiq@gmail.com';
        $user->image = null;
        $user->phone = '01700000021';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 21;
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Tamim ';
        $user->last_name = 'Iqbal';
        $user->email = 'tamim@gmail.com';
        $user->image = null;
        $user->phone = '01700000022';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 22;
        $user->category_id = 2;
        $user->sub_category_id = 5;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for football star

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Messi ';
        $user->last_name = '';
        $user->email = 'messi@gmail.com';
        $user->image = null;
        $user->phone = '01700000030';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 23;
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Neymar ';
        $user->last_name = '';
        $user->email = 'neymar@gmail.com';
        $user->image = null;
        $user->phone = '01700000023';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 24;
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Ronaldo ';
        $user->last_name = '';
        $user->email = 'ronaldo@gmail.com';
        $user->image = null;
        $user->phone = '01700000024';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 25;
        $user->category_id = 2;
        $user->sub_category_id = 4;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();


        //  Musician Category

        // for Folk Music
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Momtaz';
        $user->last_name = 'Begum';
        $user->email = 'momtaj@gmail.com';
        $user->image = 'uploads/images/users/Momtaz-Begum-photo.jpg';
        $user->phone = '01700000025';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 26;
        $user->category_id = 3;
        $user->sub_category_id = 7;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // for rock music
        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'James';
        $user->last_name = '';
        $user->email = 'james@gmail.com';
        $user->image = null;
        $user->phone = '01700000026';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 27;
        $user->category_id = 3;
        $user->sub_category_id = 8;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        $user = new User();
        $user->username = $faker->userName();
        $user->first_name = 'Chirkutt';
        $user->last_name = ' ';
        $user->email = 'chirkutt@gmail.com';
        $user->image = null;
        $user->phone = '01700000027';
        $user->password = Hash::make('12345');
        $user->user_type = 'star';
        $user->parent_user = 28;
        $user->category_id = 3;
        $user->sub_category_id = 8;
        $user->status = 1;
        $user->otp = '123456';
        $user->save();

        // audition-admin
        for ($i = 1; $i < 11; $i++) {
            $user = new User();
            $user->username = $faker->userName();
            $user->first_name = 'Mr. Audition';
            $user->last_name = 'Admin ' . $i;
            $user->email = 'audition-admin' . $i . '@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '016000000' . $i;
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
        for ($i = 1; $i < 11; $i++) {
            $user = new User();
            $user->username = $faker->userName();
            $user->first_name = 'Mr. ';
            $user->last_name = 'Jury ' . $i;
            $user->email = 'jury' . $i . '@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '016110000' . $i;
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
            $jury->terms_and_condition = $faker->text;
            $jury->description = $faker->text;
            $jury->qr_code = $faker->numberBetween(100000, 999999);
            $jury->save();
        }


        for ($i = 1; $i < 11; $i++) {
            $user = new User();
            $user->username = $faker->userName();
            $user->first_name = 'Mr.';
            $user->last_name = 'User ' . $i;
            $user->email = 'user' . $i . '@gmail.com';
            $user->image = null;
            $user->cover_photo = null;
            $user->phone = '01700100012' . $i;
            $user->password = Hash::make('12345');
            $user->user_type = 'user';
            $user->status = 1;
            $user->otp = '123456';
            $user->save();
        }
    }
}
