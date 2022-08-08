<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(StaticOptionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LiveChatSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(UserInfoSeeder::class);
        $this->call(UserEducationSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PostReactSeeder::class);
        $this->call(PostImageSeeder::class);
        $this->call(PostCommentSeeder::class);
        $this->call(PostVideoSeeder::class);
        $this->call(MeetupEventSeeder::class);
        $this->call(MeetupEventRegistaionSeeder::class);
        $this->call(LearningSessionSeeder::class);
        $this->call(LearningSessionRegSeeder::class);
        $this->call(LiveChatRegistrationSeeder::class);
        $this->call(SuperStartSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(GreetingTypeSeeder::class);

        // audition related seeder
        // $this->call(Audition\AuditionSeeder::class);
        // $this->call(Audition\AuditionJudgeInstructionSeeder::class);
        // $this->call(Audition\AuditionUploadVideoSeeder::class);
        // $this->call(Audition\AuditionAssignJurySeeder::class);
        // $this->call(Audition\AuditionRulesSeeder::class);
        // $this->call(Audition\AuditionRoundRulesSeeder::class);
        // $this->call(Audition\AuditionAssignJudgeSeeder::class);
        // $this->call(Audition\AuditionParticipantsSeeder::class);

    }
}
