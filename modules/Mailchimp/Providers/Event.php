<?php

namespace Modules\Mailchimp\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Mailchimp\Listeners\MailchimpUser;

class Event extends ServiceProvider
{
    protected $listen = [];

    protected $subscribe = [
        MailchimpUser::class,
    ];
}