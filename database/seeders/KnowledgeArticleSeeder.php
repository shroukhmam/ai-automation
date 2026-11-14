<?php

namespace Database\Seeders;

use App\Models\KnowledgeArticle;
use Illuminate\Database\Seeder;
use Laravel\Ai\Embeddings;

class KnowledgeArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            ['title' => 'سياسة الاسترجاع', 'content' => 'يمكن إرجاع أي منتج خلال 14 يوم من الاستلام بشرط أن يكون بحالته الأصلية. المبلغ يرجع لنفس وسيلة الدفع خلال 5 إلى 7 أيام عمل.'],
            ['title' => 'مناطق الشحن', 'content' => 'نشحن لكل محافظات مصر. القاهرة والجيزة خلال يومين، وباقي المحافظات من 3 إلى 5 أيام. الشحن مجاني للطلبات فوق 1000 جنيه.'],
            ['title' => 'طرق الدفع', 'content' => 'نقبل الفيزا والماستركارد وفودافون كاش والدفع عند الاستلام. الدفع عند الاستلام متاح للطلبات حتى 5000 جنيه.'],
            ['title' => 'تغيير كلمة المرور', 'content' => 'من صفحة الحساب اختار الأمان ثم تغيير كلمة المرور. لو نسيتها استخدم رابط نسيت كلمة المرور في صفحة الدخول.'],
            ['title' => 'إلغاء الطلب', 'content' => 'يمكن إلغاء الطلب مجاناً قبل شحنه من صفحة طلباتي. بعد الشحن يجب انتظار الاستلام ثم طلب الإرجاع.'],
            ['title' => 'مواعيد خدمة العملاء', 'content' => 'خدمة العملاء متاحة من السبت إلى الخميس من 9 صباحاً حتى 9 مساءً عبر الشات والتليفون.'],
        ];

        $embeddings = Embeddings::for(
            array_map(fn($a) => $a['title'] . "\n" . $a['content'], $articles)
        )->generate()->embeddings;

        foreach ($articles as $i => $article) {
            KnowledgeArticle::create([...$article, 'embedding' => $embeddings[$i]]);
        }
    }
}
