<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            SimplePostSeeder::class,
            LearningSessionSeeder::class,
            MeetupEventSeeder::class,
            LiveChatSeeder::class,
            QnASeeder::class,
            GreetingSeeder::class,
            MarketPlaceSeeder::class,
            SouvenirSeeder::class,
            AuctionSeeder::class,
            InterestTypeSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            EducationLevelSeeder::class,
            AboutUsSeeder::class,
            PrivacyPolicySeeder::class,
            ProductPurchaseSeeder::class,
            RefundPolicySeeder::class,
            TermAndConditionSeeder::class,
            FaqSeeder::class,
            OccupationSeeder::class,
            PackageSeeder::class,
        ]);


        // $this->call(StaticOptionSeeder::class);
        // $this->call(LiveChatSeeder::class);
        // $this->call(UserInfoSeeder::class);
        // $this->call(UserEducationSeeder::class);
        // $this->call(PostSeeder::class);
        // $this->call(PostReactSeeder::class);
        // $this->call(PostImageSeeder::class);
        // $this->call(PostCommentSeeder::class);
        // $this->call(PostVideoSeeder::class);
        // $this->call(MeetupEventRegistaionSeeder::class);
        // $this->call(LiveChatRegistrationSeeder::class);
        // $this->call(SuperStarSeeder::class);
        // $this->call(PaymentSeeder::class);
        // $this->call(GreetingTypeSeeder::class);





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
