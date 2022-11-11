<?php

namespace App\Traits\Expedition;

use App\Address;
use App\Models\SimpleDelivery;

trait HasSimpleDelivery
{
    public function expeditionRules(){

        return [
            'deliveryAreaId' => ['required','not_in:0'],
            'address_id' => ['required','string'],
            'customFields.client_name' =>['required', 'min:2'],
            'customFields.email' => ['required', 'email', 'regex:/(.+)@(.+)\.(.+)/i'],
            'phone' => ['required', 'min:0000000000', 'max:9999999999', 'starts_with:04,05', 'numeric'],

        ];
    }

    public function expeditionMessages() {
        return [
            'phone.required' => 'Please enter your valid mobile number. Example - 0412 123 123',
            'phone.starts_with' => 'Please enter your valid mobile number. Example - 0412 123 123',
            'phone.min' => 'Please enter your valid mobile number. Example - 0412 123 123',
            'phone.max' => 'Please enter your valid mobile number. Example - 0412 123 123',
            'phone.numeric' => 'Please enter your valid mobile number. Example - 0412 123 123',
            'customFields.client_name.required' => 'Name is required',
            'customFields.email.regex' => 'Email is no correct',
            'customFields.email.email' => 'Email is no correct',
            'customFields.email.required' => 'Email is required',
            'deliveryAreaId.required' => 'Please choose your suburb',
            'deliveryAreaId.not_in' => 'Please choose your suburb',
            'address_id.required' => 'Please enter your delivery address'
        ];
    }

    public function setAddressAndApplyDeliveryFee(){
            if($this->request->has('phone')){
                $this->order->phone= $this->request->phone;
            }
            $this->order->whatsapp_address=$this->request->address_id;
            if($this->request->deliveryAreaId){
                $this->order->delivery_price = SimpleDelivery::findOrFail($this->request->deliveryAreaId)->cost;
            }else{
                $this->order->delivery_price = 0;
            }

            $this->order->update();
    }

    public function setTimeSlot(){
        $this->order->delivery_pickup_interval=$this->request->timeslot;
        $this->order->update();
    }
}
