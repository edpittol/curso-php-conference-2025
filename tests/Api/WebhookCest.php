<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\Support\ApiTester;

class WebhookCest
{
    public function testWebhookEndpoint(ApiTester $apiTester): void
    {
        $apiTester->haveInDatabase('wp_wc_orders', [
            'id' => 123,
            'status' => 'wc-pending',
            'type' => 'shop_order',
        ]);

        $apiTester->haveInDatabase('wp_wc_orders_meta', [
            'order_id' => 123,
            'meta_key' => '_asaas_payment_id',
            'meta_value' => 'payment_12345',
        ]);

        $apiTester->haveHttpHeader('Content-Type', 'application/json');
        $apiTester->sendPOST('/wp-json/curso-php-conference-2025/v1/webhook', [
            'payment' => [
                'id' => 'payment_12345',
                'status' => 'RECEIVED',
            ],
        ]);

        $apiTester->seeResponseCodeIs(200);
        $apiTester->seeInDatabase('wp_wc_orders', [
            'ID' => 123,
            'status' => 'wc-completed',
        ]);
    }
}
