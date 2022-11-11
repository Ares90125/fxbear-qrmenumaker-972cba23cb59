<?php

namespace Modules\Detrack\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Detrack\Listeners\SubmitOnOrder;

class Event extends ServiceProvider
{
    protected $listen = [];

    protected $subscribe = [
        SubmitOnOrder::class,
    ];
}