<?php

use Illuminate\Support\Facades\Route;
use App\Ai\Agents\TicketSummarizer;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/summary', function () {
    $message = 'أنا بقالي 3 أيام بحاول أدفع الاشتراك والفيزا بترفض كل مرة!! '
        . 'وبعتلكم إيميلين ومحدش رد، لو المشكلة ما اتحلتش النهارده هلغي الاشتراك.';

    $response = (new TicketSummarizer)->prompt($message);

    return (string) $response;
});

