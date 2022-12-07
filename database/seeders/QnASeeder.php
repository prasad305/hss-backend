<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\QnA;
use App\Models\QnaRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QnASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QnA::factory(2)->create([
            'category_id' => 2,
            'sub_category_id' => 5,
            'created_by_id' => 20,
            'admin_id' => 20,
            'star_id' => 38,
        ])->each(function ($event) {

            Post::create([
                'type' => 'qna',
                'user_id' => $event->star_id,
                'star_id' => $event->star_id,
                'event_id' =>  $event->id,
                'category_id' =>  $event->category_id,
                'sub_category_id' =>  $event->sub_category_id,
                'title' =>  $event->title,
                'details' =>  $event->description,

            ]);
            User::factory(5)->create()->each(function ($user) use ($event) {

                $qna = QnA::find($event->id);

                QnaRegistration::factory(1)->create([
                    'qna_id' => $event->id,
                    'user_id' => $user->id,
                    'qna_start_time' => (Carbon::parse($qna->available_start_time)->format('H:i:s')),
                    'qna_end_time' => (Carbon::parse($qna->available_start_time)->addMinutes(7)->format('H:i:s')),
                    'qna_date' => $event->event_date,
                ])->each(function ($registerInfo) use ($event) {
                    QnA::where('id', $event->id)->update([
                        'available_start_time' => (Carbon::parse($registerInfo->qna_end_time)->addMinutes($event->interval)->format('H:i:s')),
                    ]);
                    createSeederActivity("qna", $registerInfo->id, $registerInfo->user_id, $registerInfo->qna_id);
                });
            });
        });
    }
}
