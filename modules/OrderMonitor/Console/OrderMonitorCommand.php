<?php

namespace Modules\OrderMonitor\Console;

use App\Order;
use App\Services\SmsService;
use App\Status;
use Illuminate\Console\Command;
use Twilio\Rest\Client;

class OrderMonitorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public $test = true;

    public function handle()
    {

        $statuses = Status::whereIn('alias', ['just_created']) // whereIn - for new statuses
        ->get()
            ->pluck('id')
            ->toArray();

        $orders = Order::whereHas('laststatus', function($q) use($statuses) {
            $q->whereIn('status_id', $statuses);
        })
            ->where('created_at', '<',now()->subMinutes(2))
            ->where(function ($query) {
                $query->where('status_monitor', '<', 4)
                    ->orWhereNull('status_monitor'); // status 4 means all alerts have been completed
            })
            ->get();


        if($orders->count() > 0) {
            foreach ($orders as $order) {
                $this->checkStatusMonitor($order);
            }
        }

        return true;

    }

    public function checkStatusMonitor($order) {

        switch ($order->status_monitor) {

            case 2:
            case 3:
                $this->callClient($order);
                break;
            default:
                $this->sendSms($order);
                break;

        }

        $order->status_monitor += 1;
        $order->save();

    }

    public function sendSms($order) {

        $message = 'OpenStation';
        $client = $order->restorant;

        if(!$client->phone) {
            return false;
        }

        if($this->test) {
            info('send sms '. $order->id. ' status - '. $order->status_monitor);
            return false;
        }

        if(env('SEND_SMS_TO_CUSTOMER', true) === true) {
            SmsService::sendSms($client->phone, htmlspecialchars_decode(($message)));
        }

        if(env('SEND_SMS_TO_CUSTOMER_ALERT', true) === true) {
            SmsService::sendSmsAlert($client->phone, htmlspecialchars_decode(($message)));
        }


    }

    public function callClient($order) {

        if($order->status_monitor != 3) {
            $phone = $order->restorant->whatsapp_phone; // number restorant
        }
        else {
            $phone = $order->restorant->phone; // number administrator
        }


        if($this->test) {
            info('call client '. $order->id. ' status - '. $order->status_monitor);
            return false;
        }

        if($phone) {
            $message = 'OpenStation order '. $order->id;
            $client = new Client(config('settings.twilio_sid'), config('settings.twilio_auth_token'));
            $body = __('Hi').' '.$order->restorant->name.".\n\n".$message;
            $client->messages->create($phone, ['from' => config('settings.twilio_from'), 'body' => $body]);
        }

    }
}
