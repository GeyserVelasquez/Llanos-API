<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('greet {name}', function ($name) {
    $this->comment("Hello $name. Welcome tu Llanos API.");
})->purpose('Display a greeting');
