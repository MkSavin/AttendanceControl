<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('api-token {email}', function () {
    $user = User::where('email', $this->argument('email'))->firstOrFail();
    $token = Str::random(80);
    $user->forceFill(['api_token' => hash('sha256', $token)])->save();

    $this->info($token);
})->describe('Issue a new API token for a user');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
