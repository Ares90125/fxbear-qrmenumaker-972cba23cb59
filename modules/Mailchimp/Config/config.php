<?php

return [
    'name' => 'Mailchimp',
    'mc_api'=>env('MAILCHIMP_API_KEY_MODULE',''),
    'mc_server'=>env('MAILCHIMP_SERVER_MODULE',''),
    'mc_list'=>env('MAILCHIMP_LISTID_MODULE','')
];
