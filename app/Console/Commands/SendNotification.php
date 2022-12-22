<?php

namespace App\Console\Commands;

use App\Mail\UserScheduleNotification;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user';

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
        // get all reminders for today
            $star_reminders = Schedule::where('remainder_date',now()->format('Y-m-d'))
            ->where('status',1)
            ->orderBy('star_id')
            ->get();

            $admin_reminders = Schedule::where('remainder_date',now()->format('Y-m-d'))
            ->where('status',1)
            ->orderBy('admin_id')
            ->get();
        // group by user
        $star_data = [];

        foreach ($star_reminders as $star_reminder) {
            $star_data[$star_reminder->star_id][] = $star_reminder->toArray();
        }
    

        $admin_data = [];

        foreach ($admin_reminders as $admin_reminder) {
            $admin_data[$admin_reminder->admin_id][] = $admin_reminder->toArray();

            // $message = 'you have schedule at'.Carbon::parse($admin_reminder->from)->format('h:s A').'to'.Carbon::parse($admin_reminder->to)->format('h:s A').' On'.Carbon::parse($admin_reminder->date)->format('Y M,d');
            // send_sms($message,$admin_reminder->admin->phone);
       
        }

        // dd($admin_data);

        foreach ($star_data as $starId => $remainder) {
           $this->sendEmailToStar($starId,$remainder);
        }

        

        foreach ($admin_data as $adminId => $remainder) {
           $this->sendEmailToStar($adminId,$remainder);
        }

        //send email

       
        // return 0;
    }

    private function sendEmailToStar($starId,$remainder){

        $star = User::find($starId);

        // for send email
        Mail::to($star->email)->send(new UserScheduleNotification($remainder));

    }


}
