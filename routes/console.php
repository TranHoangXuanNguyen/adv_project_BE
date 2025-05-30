<?php
// routes/console.php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Http;

Schedule::call(function () {
    $response = Http::post('http://127.0.0.1:8000/api/remind', [
        'message' => 'Request tự động từ Laravel!'
    ]);
    \Log::info('Task ran with response: ' . $response->body());
})->dailyAt('09:38');

