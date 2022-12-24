<?php

namespace App\Jobs\StripeWebhhoks;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class ChargeSuccessededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {

        $charge = $this->webhookCall->payload['data']['object'];
        $user_event = explode('_', $charge['description']);
        $event_id = $user_event[2];
        $event_type = $user_event[1];
        $user_id = $user_event[0];
        $value = $user_event[4];

        Transaction::create([
            'user_id' => $user_id,
            'order_id' => $charge['id'],
            'txn_id' => $charge['balance_transaction'],
            'currency' => $charge['currency'],
            'txn_amount' => $charge['amount'],
            'status' => $charge['status'],
            'event' => $event_type,
            'event_id' =>  $event_id,
            'bank_name' => "Stripe-Payment",
            'resp_msg' => $charge['description'],

        ]);


        return resgistationSuccessUpdate($user_id, $event_type, $event_id, "Stripe-Payment", $charge['amount'], $value);

        // do your work here

        // you can access the payload of the webhook call with `$this->webhookCall->payload`
    }
}
