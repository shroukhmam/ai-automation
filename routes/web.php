<?php

use Illuminate\Support\Facades\Route;
use App\Ai\Agents\TicketSummarizer;
use App\Models\KnowledgeArticle;
use App\Ai\Agents\SupportAssistant;
use App\Models\User;



Route::get('/test/stream', function () {
    $user = User::where('email', 'ahmed@test.com')->first();

    return (new SupportAssistant)
        ->forUser($user)
        ->stream(request('msg', 'إيه سياسة الاسترجاع عندكم؟'));
});
Route::get('/test/chat', function () {
    $user    = User::where('email', 'ahmed@test.com')->first(); // في التطبيق الحقيقي: auth()->user()
    $message = request('msg');
    $cid     = request('cid');

    $agent = new SupportAssistant;

    $agent = $cid
        ? $agent->continue($cid, as: $user)   // كمّل محادثة قديمة
        : $agent->forUser($user);             // ابدأ محادثة جديدة

    $response = $agent->prompt($message);

    return response()->json([
        'conversation_id' => $response->conversationId,
        'reply'           => (string) $response,
    ], 200, [], JSON_UNESCAPED_UNICODE);
});
Route::get('/test/assistant', function () {
    $message = request('msg', ' طلبي رقم ORD-1001 وإيميلي ahmed@test.com، هيوصل امتى؟واعرضلى الطلب ');

    return (string) (new SupportAssistant)->prompt($message);
});

Route::get('/test/search', function () {
    $query = request('q', 'عايز فلوسي ترجع');

    return KnowledgeArticle::query()
        ->whereVectorSimilarTo('embedding', $query, minSimilarity: 0.6)
        ->limit(3)
        ->get(['id', 'title']);
});
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
