<?php

use Illuminate\Support\Facades\Route;
use App\Ai\Agents\TicketSummarizer;

Route::get('/test/summary', function () {
    $messages = [
        'غاضب'  => 'أنا بقالي 3 أيام بحاول أدفع الاشتراك والفيزا بترفض كل مرة!! وبعتلكم إيميلين ومحدش رد، لو المشكلة ما اتحلتش النهارده هلغي الاشتراك.',
        'عادي'  => 'لو سمحت عايز أعرف إزاي أغير الباسورد بتاع حسابي.',
        'خارج'  => 'إزيك عامل إيه؟ الجو حلو النهارده.',
    ];

    $results = [];
    foreach ($messages as $type => $message) {
        $results[$type] = (string) (new TicketSummarizer)->prompt($message);
    }

    return response()->json($results, 200, [], JSON_UNESCAPED_UNICODE);
});

Route::get('/test/classify', function () {
    $message = request('msg', 'الفيزا بترفض بقالها 3 أيام ومحدش بيرد، هلغي الاشتراك!');

    $result = (new \App\Ai\Agents\TicketClassifier())->prompt($message);

    $ticket = \App\Models\Ticket::create([
        'customer_message' => $message,
        'category'         => $result['category'],
        'priority'         => $result['priority'],
        'sentiment'        => $result['sentiment'],
        'summary'          => $result['summary'],
    ]);

    return response()->json($ticket, 200, [], JSON_UNESCAPED_UNICODE);
});
Route::get('/', function () {
    return view('welcome');
});
