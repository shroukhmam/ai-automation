<?php

namespace App\Ai\Tools;

use App\Models\Order;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class GetOrderStatus implements Tool
{
    public function description(): string
    {
        return 'يجيب حالة طلب العميل وموعد التوصيل المتوقع. '
            . 'استخدمها لما العميل يسأل عن طلب معين. محتاجة رقم الطلب وإيميل العميل.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'order_number' => $schema->string()->required(),
            'email'        => $schema->string()->required(),
        ];
    }

    public function handle(Request $request): string
    {
        $order = Order::where('order_number', $request['order_number'])
            ->where('customer_email', $request['email'])
            ->first();

        if (! $order) {
            return 'مفيش طلب بالرقم ده مرتبط بالإيميل ده.';
        }

        return json_encode([
            'order_number'      => $order->order_number,
            'status'            => $order->status,
            'total'             => $order->total,
            'expected_delivery' => $order->expected_delivery,
        ], JSON_UNESCAPED_UNICODE);
    }
}
