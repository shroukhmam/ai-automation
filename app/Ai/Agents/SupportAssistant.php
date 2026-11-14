<?php

namespace App\Ai\Agents;

use App\Ai\Tools\GetOrderStatus;
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
        PROMPT;
    }

    public function tools(): iterable
    {
        return [
            new GetOrderStatus,
        ];
    }
}
