<?php

namespace App\Console\Commands;

use App\Models\LiveChat;
use App\Models\MeetupEvent;
use App\Models\QnA;
use Illuminate\Console\Command;

class EventCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This event successfully completed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       LiveChat::where('event_date','<',today())->each(function($event){
            $event->status = 9;
            $event->save();
        });
        QnA::where('event_date','<',today())->each(function($event){
            $event->status = 9;
            $event->save();
        });
        MeetupEvent::where('event_date','<',today())->each(function($event){
            $event->status = 9;
            $event->save();
        });

        $this->info("Event Successfully Completed !");
    }
}
