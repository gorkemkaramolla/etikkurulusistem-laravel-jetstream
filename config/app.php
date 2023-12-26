<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;
use LaravelLang\JsonFallbackHotfix\TranslationServiceProvider as JsonTranslationServiceProvider;

return [

    'name' => env('APP_NAME', 'Laravel'),

    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),


    'timezone' => 'UTC',



    'locale' => 'tr',



    'fallback_locale' => 'en',



    'faker_locale' => 'en_US',



    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',



    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],



    'providers' => ServiceProvider::defaultProviders()->merge([

        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
    ])->replace([
        BaseTranslationServiceProvider::class => JsonTranslationServiceProvider::class,
    ])->toArray(),




    'aliases' => Facade::defaultAliases()->merge([])->toArray(),

];
