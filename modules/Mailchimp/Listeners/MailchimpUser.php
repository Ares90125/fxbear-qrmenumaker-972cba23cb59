<?php

namespace Modules\Mailchimp\Listeners;

require __DIR__.'/../vendor/autoload.php';
use MailchimpMarketing\ApiClient;
use MailchimpMarketing\ApiException;


class MailchimpUser
{


    public function handleNewVendor($event){
        if(strlen(config('mailchimp.mc_api','')>3)){
            $user=$event->user;
            $vendor=$event->vendor;

            $mailchimp =  new ApiClient();

            $mailchimp->setConfig([
                'apiKey' => config('mailchimp.mc_api'),
                'server' => config('mailchimp.mc_server')
            ]);


            $list_id = config('mailchimp.mc_list');

            try {
                $response = $mailchimp->lists->addListMember($list_id, [
                    "email_address" => $user->email,
                    "status" => "subscribed",
                    "merge_fields" => [
                        "FNAME" =>$user->name,
                        "PHONE" =>$user->phone,
                        "VENDOR"=>$vendor->name
                    ]
                ]);
            } catch (ApiException $e) {
            // dd( $e->getMessage())
                //echo $e->getMessage();
            }
        }
        

    }


    public function subscribe($events)
        {
            $events->listen(
                'App\Events\NewVendor',
                [MailchimpUser::class, 'handleNewVendor']
            );
        }
}

?>