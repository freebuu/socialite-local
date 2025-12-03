<?php
return [
    // Default to off in production; enable explicitly with SOCIALITE_LOCAL_ENABLED=true
    'enabled' => env('SOCIALITE_LOCAL_ENABLED', env('APP_ENV', 'production') !== 'production'),
    'use_original_mapper' => env('SOCIALITE_LOCAL_USE_ORIGINAL_MAPPER', true),
];
