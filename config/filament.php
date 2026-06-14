<?php

return [
    'path' => 'admin',
    'domain' => null,
    'use_path_for_asset_url' => false,
    'middleware' => [
        'web',
        'auth',
    ],
    'auth' => [
        'guard' => 'web',
    ],
];
