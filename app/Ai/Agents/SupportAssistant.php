<?php

namespace App\Ai\Agents;

use App\Ai\Tools\GetOrderStatus;
use App\Ai\Tools\SearchKnowledgeBase;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;

class SupportAssistant implements Agent, HasTools
{
    use Promptable;

    public function instructions(): string
    {
        return <<<PROMPT
    إنت مساعد خدمة عملاء لمتجر إلكتروني، وبترد بالعربي بأسلوب ودود ومختصر.
    لو العميل سأل عن طلب، استخدم أداة GetOrderStatus.
    لو ناقصك رقم الطلب أو الإيميل، اطلبهم من العميل وما تخمنش.
    ما تألفش أي معلومة عن الطلب، اعتمد على نتيجة الأداة بس.
    للأسئلة العامة استخدم أداة SearchKnowledgeBase، وجاوب من نتيجتها بس.
    لو الأداة ما رجعتش معلومة كفاية، قول للعميل إنك هتحوله لموظف، وما تخمنش.
    لو السؤال محتاج معلومات من الطلب ومن السياسات مع بعض، استخدم الأداتين.
    PROMPT;
    }

    public function tools(): iterable
    {
        return [
            new GetOrderStatus,
            new SearchKnowledgeBase,
        ];
    }
}
