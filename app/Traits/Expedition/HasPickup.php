<?php

namespace App\Traits\Expedition;

trait HasPickup
{
    public function expeditionRules(){

        return [
            'customFields.client_name' =>['required', 'min:2'],
            'customFields.email' => ['required', 'email'],
            'phone' => ['required', 'min:10', 'max:9999999999', 'starts_with:04,05', 'numeric'],
            'timeslot' =>['required']
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
            'address_id.required' => 'Please enter your delivery address'
        ];
    }


    public function setAddressAndApplyDeliveryFee(){
        //In case we have phone, save it
        if($this->request->has('phone')){
            $this->order->phone= $this->request->phone;
        }
        $this->order->delivery_price= 0;
        $this->order->update();
    }

    public function setTimeSlot(){
        $this->order->delivery_pickup_interval=$this->request->timeslot;
        $this->order->update();
    }




}
