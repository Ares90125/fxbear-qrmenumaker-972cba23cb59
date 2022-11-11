<?php

namespace App\Observers;

use App\Models\RestaurantCallback;
use App\Status;

class RestaurantCallbackObserver
{
    /**
     * Handle the RestaurantCallback "created" event.
     *
     * @param  \App\Models\RestaurantCallback  $restaurantCallback
     * @return void
     */
    public function created(RestaurantCallback $restaurantCallback)
    {
        $order = $restaurantCallback->order;


        $statusAccepted = Status::where('alias', 'accepted_by_restaurant')->firstOrFail();
        $statusRejected = Status::where('alias', 'rejected_by_restaurant')->firstOrFail();

        \DB::table('order_has_status')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'order_id' => $order->id,
            'user_id' => $order->client_id ?? 1,
            'status_id' => $restaurantCallback->restaurant_answer == 'ACCEPTED' ? $statusAccepted->id : $statusRejected->id,
            'comment' => $restaurantCallback->why_rejected
        ]);

    }


    /**
     * Handle the RestaurantCallback "updated" event.
     *
     * @param  \App\Models\RestaurantCallback  $restaurantCallback
     * @return void
     */
    public function updated(RestaurantCallback $restaurantCallback)
    {
        //
    }

    /**
     * Handle the RestaurantCallback "deleted" event.
     *
     * @param  \App\Models\RestaurantCallback  $restaurantCallback
     * @return void
     */
    public function deleted(RestaurantCallback $restaurantCallback)
    {
        //
    }

    /**
     * Handle the RestaurantCallback "restored" event.
     *
     * @param  \App\Models\RestaurantCallback  $restaurantCallback
     * @return void
     */
    public function restored(RestaurantCallback $restaurantCallback)
    {
        //
    }

    /**
     * Handle the RestaurantCallback "force deleted" event.
     *
     * @param  \App\Models\RestaurantCallback  $restaurantCallback
     * @return void
     */
    public function forceDeleted(RestaurantCallback $restaurantCallback)
    {
        //
    }
}
