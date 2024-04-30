<?php

use App\Controllers\MainController;

return [
    'POST' => [
        '/api/upload' => [MainController::class, 'upload'],
    ],
    'GET' => [
        '/api/mailing' => [MainController::class, 'mailing'],
        '/' => [MainController::class, 'index']
    ]
];