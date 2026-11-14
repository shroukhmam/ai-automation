<?php

namespace App\Ai\Tools;

use App\Models\KnowledgeArticle;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class SearchKnowledgeBase implements Tool
{
    public function description(): string
    {
        return 'يدور في مقالات المساعدة بتاعة المتجر. استخدمها لأي سؤال عن السياسات، '
            . 'أو الشحن، أو الدفع، أو الحساب، أو مواعيد العمل.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'query' => $schema->string()->required(),
        ];
    }

    public function handle(Request $request): string
    {
        $articles = KnowledgeArticle::query()
            ->whereVectorSimilarTo('embedding', $request['query'], minSimilarity: 0.4)
            ->limit(3)
            ->get(['title', 'content']);

        if ($articles->isEmpty()) {
            return 'مفيش مقالات مناسبة للسؤال ده.';
        }

        return $articles->map(fn ($a) => "## {$a->title}\n{$a->content}")->implode("\n\n");
    }
}
