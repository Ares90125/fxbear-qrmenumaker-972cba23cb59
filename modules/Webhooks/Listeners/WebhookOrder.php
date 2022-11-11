<?php

namespace Modules\Webhooks\Listeners;
use App\Models\Options;

class WebhookOrder
{
    private function notify($send_data, $webhook){

        //$client = new \GuzzleHttp\Client();
        $payload = $send_data;

        //$client = new \GuzzleHttp\Client();
        //$response = $client->request('POST', $webhook, $payload);

        
        $data['shopname']    = $payload['shopname'];
        $data['orderString'] = $payload['orderString'];
        $api_url             = $webhook;

        $data_string = json_encode($data);
        $ch = curl_init("$api_url");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        curl_exec($ch);

        //var_dump($response);exit;
    }

    
    public function handleOrderAcceptedByAdmin($event) {


        $order = $event->data['order'];
        $payload = $event->data['payload'];

        $vendor = $order->restorant;

        //Vendor setup
        $webhook_for_vendor = $vendor->getConfig('webhook_url_by_admin','');

        //Admin setup
        $webhook_for_admin = config('webhook.webhook_by_admin');

        //Notify Admin
        if(strlen($webhook_for_admin) > 5){
            $this->notify($payload, $webhook_for_admin);
        }
        
        //Notify Owner
        if(strlen($webhook_for_vendor) > 5){
            $this->notify($payload, $webhook_for_vendor);
        }
        
    }

    public function handleOrderAcceptedByVendor($event) {
        
        $order = $event->data['order'];
        $payload = $event->data['payload'];
        $vendor = $order->restorant;

        //Vendor setup
        $webhook_for_vendor = $vendor->getConfig('webhook_url_by_vendor','');

        //Admin setup
        $webhook_for_admin = config('webhook.webhook_by_vendor');
        

        //Notify Admin  
        if(strlen($webhook_for_admin) > 5){
            $this->notify($payload, $webhook_for_admin);
        }
        
        //Notify Owner
        if(strlen($webhook_for_vendor) > 5){
            $this->notify($payload, $webhook_for_vendor);
        }
    }

    public function handleNewVendor($event){
        $user = $event->user;
        $vendor = $event->vendor;

         //Admin setup
         $webhook_for_admin = config('webhook.webhook_new_vendor');

          //Notify Admin
        if(strlen($webhook_for_admin)>5){
            $client = new \GuzzleHttp\Client();

            $payload = [
                'form_params' => [
                    'user' => $user->toArray(),
                    'vendor' => $vendor->toArray()
                ],
            ];

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $webhook_for_admin, $payload);
        } 
    }

    public function subscribe($events)
        {
            $events->listen(
                'App\Events\OrderAcceptedByAdmin',
                [WebhookOrder::class, 'handleOrderAcceptedByAdmin']
            );

            $events->listen(
                'App\Events\OrderAcceptedByVendor',
                [WebhookOrder::class, 'handleOrderAcceptedByVendor']
            );

            $events->listen(
                'App\Events\NewVendor',
                [WebhookOrder::class, 'handleNewVendor']
            );
        }
}

?>