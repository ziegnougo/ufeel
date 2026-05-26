<?php

return [
    'name'            => env('APP_NAME', 'UFEEL'),
    'env'             => env('APP_ENV', 'production'),
    'debug'           => (bool) env('APP_DEBUG', false),
    'url'             => env('APP_URL', 'http://localhost'),
    'timezone'        => 'Africa/Abidjan',
    'locale'          => 'fr',
    'fallback_locale' => 'fr',
    'faker_locale'    => 'fr_FR',
    'cipher'          => 'AES-256-CBC',
    'key'             => env('APP_KEY'),
    'previous_keys'   => array_filter(explode(',', env('APP_PREVIOUS_KEYS', ''))),
    'maintenance'     => ['driver' => 'file'],
    'providers'       => Illuminate\Support\AggregateServiceProvider::defaultProviders()->merge([])->toArray(),
    'aliases'         => Illuminate\Foundation\AliasLoader::getInstance()->getAliases(),
];
