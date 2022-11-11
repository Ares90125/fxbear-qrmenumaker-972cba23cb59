<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    /**
     * @param $phone
     * @param $text
     * @return false|void
     */
    public static function sendSms($phone, $text)
    {
        if (empty($phone) || empty($text)) {
            return false;
        }

        Http::get('https://api.smsbroadcast.com.au/api-adv.php?APIKeyUsername='.env('SMSBROADCAST_USERNAME').'&APIKeyPassword='.env('SMSBROADCAST_PASS').'&to='.$phone.'&MyCompany&message='.urlencode($text));
    }

    public static function sendSmsAlert($phone, $text)
    {
        if (empty($phone) || empty($text)) {
            return false;
        }

        Http::post('https://smsalert.mobi/api/sms/send?username='.env('SMS_ALERT_BROADCAST_USERNAME').'&apiKey='.env('SMS_ALERT_BROADCAST_APIKEY').'&tel='.$phone.'&message='.urlencode($text));


    }
}
