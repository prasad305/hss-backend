<?php

namespace App\Listeners;

use App\Events\RegistarNewStarFollow;
use App\Models\ChoiceList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserFollowersUpdate implements ShouldQueue

{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RegistarNewStarFollow  $event
     * @return void
     */
    public function handle(RegistarNewStarFollow $event)
    {

        // $followrs = ChoiceList::get()->each(function($follower) use($event){
        //     $followerStar =  json_decode($follower->star_id);
        //     array_push($followerStar,$event->star_id);
        //     $follower->star_id = json_encode($followerStar,JSON_NUMERIC_CHECK);
        //     $follower->save();
        // });
        $followrs = ChoiceList::get();
        foreach ($followrs as $key => $follower) {
            $followerStar =  json_decode($follower->star_id);
            array_push($followerStar,$event->star_id);
            $follower->star_id = json_encode($followerStar,JSON_NUMERIC_CHECK);
            $follower->save();
            sleep(2);

        }

    }
}
