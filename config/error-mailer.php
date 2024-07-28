<?php

return [
    'email' => [
        'recipient' => ['friswardani90@gmail.com'],
        'bcc' => ['friswardani@gmail.com'],
        'cc' => ['jerukjember@gmail.com'],
        'subject' => 'An error was occured - ' . env('APP_NAME'),
    ],

    'disabledOn' => [
      'local',  //
    ],

    'cacheCooldown' => 10, // in minutes
];
