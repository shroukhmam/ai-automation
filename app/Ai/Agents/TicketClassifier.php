<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;

class TicketClassifier implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): string
    {
        return <<<PROMPT
        إنت نظام تصنيف تذاكر دعم فني.
        حلّل رسالة العميل وحدد:
        - category: نوع المشكلة.
        - priority: الأولوية. urgent لو العميل بيهدد بالإلغاء أو في خسارة فلوس، high لو الخدمة واقفة، medium للمشاكل العادية، low للأسئلة والاستفسارات.
        - sentiment: مشاعر العميل.
        - summary: ملخص في جملة واحدة بالعربي.
        اعتمد على الرسالة بس، وما تفترضش معلومات مش موجودة.
        PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'category'  => $schema->string()->enum(['billing', 'technical', 'account', 'general'])->required(),
            'priority'  => $schema->string()->enum(['low', 'medium', 'high', 'urgent'])->required(),
            'sentiment' => $schema->string()->enum(['positive', 'neutral', 'negative', 'angry'])->required(),
            'summary'   => $schema->string()->required(),
        ];
    }
}
