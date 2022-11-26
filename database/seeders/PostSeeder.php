<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // for ($i = 1; $i < 10; $i++) {
        //     $Post = new Post();
        //     $Post->type =  'meetup';
        //     $Post->event_id =  $faker->numberBetween(1, 20);
        //     $Post->user_id =  $faker->numberBetween(1, 4);
        //     $Post->comment_number = $faker->numberBetween(1, 5);
        //     $Post->react_number = $faker->numberBetween(1, 5);
        //     $Post->share_number = $faker->numberBetween(1, 5);
        //     $Post->title = $faker->text(20);
        //     $Post->details = $faker->text(100);
        //     $Post->share_link = null;
        //     $Post->category_id = 1;
        //     $Post->status = 1;
        //     $Post->save();
        // };


        Post::create([
            'type' => 'meetup',
            'user_id' => '4',
            'event_id' => '15',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '3',
            'react_number' => '3',
            'share_number' => '4',
            'title' => 'Voluptatem in et.',
            'details' => 'Et rerum aut quidem qui voluptatum repellendus cum. Quo praesentium quas unde a ut tempore.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);


        Post::create([
            'type' => 'meetup',
            'user_id' => '3',
            'event_id' => '18',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '4',
            'react_number' => '5',
            'share_number' => '1',
            'title' => 'Doloremque.',
            'details' => 'Aperiam illo ut id non. Molestiae ab aut temporibus. Tempora eos veniam est explicabo ea.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '1',
            'event_id' => '4',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '4',
            'react_number' => '5',
            'share_number' => '2',
            'title' => 'Corrupti illum.',
            'details' => 'Delectus velit laborum expedita. Eum voluptatem dolore dignissimos rem.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '3',
            'event_id' => '18',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '3',
            'react_number' => '4',
            'share_number' => '4',
            'title' => 'Est nihil repellat.',
            'details' => 'Odit sequi et quis eum. Perferendis repellat non doloremque ut saepe cumque.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '4',
            'event_id' => '13',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '4',
            'react_number' => '2',
            'share_number' => '5',
            'title' => 'Praesentium.',
            'details' => 'Et at sed qui recusandae maiores aperiam. Eum sunt ut quis impedit fugiat ut.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '2',
            'event_id' => '3',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '2',
            'react_number' => '1',
            'share_number' => '4',
            'title' => 'Dolores eligendi.',
            'details' => 'Atque nam et fugiat deleniti excepturi. Sint rerum aut aliquam accusantium quia aperiam dolores.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '3',
            'event_id' => '18',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '5',
            'react_number' => '5',
            'share_number' => '4',
            'title' => 'Itaque nihil ut.',
            'details' => 'Aut ut error sit. Doloribus et mollitia sit cum totam.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '4',
            'event_id' => '8',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '5',
            'react_number' => '3',
            'share_number' => '2',
            'title' => 'Temporibus alias.',
            'details' => 'Minus eveniet nam soluta in nam animi. Quia numquam vel adipisci et et provident.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'meetup',
            'user_id' => '2',
            'event_id' => '15',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '3',
            'react_number' => '2',
            'share_number' => '3',
            'title' => 'Atque quia.',
            'details' => 'Vero nihil doloremque perferendis quibusdam ratione. Ut molestiae doloremque delectus enim.',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:48:11',
            'updated_at' => '2022-05-17 09:48:11'
        ]);

        Post::create([
            'type' => 'audition',
            'user_id' => '1',
            'event_id' => '10',
            'category_id' => '1',
            'sub_category_id' => '0',
            'comment_number' => '0',
            'react_number' => '0',
            'share_number' => '0',
            'title' => 'Monir Talent Hunt 2022',
            'details' => '

            Monir Talent Hunt 2022 . description

            ',
            'share_link' => "sdafsafsafd/dasff/",
            'react_provider' => "adsfasfsdaf/adfasfdf",
            'status' => '1',
            'created_at' => '2022-05-17 09:49:53',
            'updated_at' => '2022-05-17 09:49:53'
        ]);
    }
}
