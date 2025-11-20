<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway;

use WC_Order;
use WC_Payment_Gateway;

class DummyGateway extends WC_Payment_Gateway
{
    public const GATEWAY_ID = 'dummy_gateway';

    public function __construct()
    {
        $this->id = self::GATEWAY_ID;
        $this->method_title = 'Dummy Gateway';
        $this->method_description = 'A dummy payment gateway for testing purposes.';
        $this->has_fields = true;

        $this->init_form_fields();
        $this->init_settings();

        $this->title = 'Fake Payment';
        $this->description = 'Pay with this dummy gateway for testing.';

        // Actions.
        add_filter('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
    }

    /**
     * @param int $order_id
     * @return array{result:string, redirect:string}
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function process_payment($order_id): array
    {
        $order = wc_get_order($order_id);

        if (\is_bool($order) || !is_a($order, WC_Order::class)) {
            return [
                'result' => 'failure',
                'redirect' => '',
            ];
        }

        $order->update_status('completed', 'Done by Dummy Gateway.');

        wc_reduce_stock_levels($order_id);

        // Remove cart.
        WC()->cart->empty_cart();

        return [
            'result' => 'success',
            'redirect' => $this->get_return_url($order),
        ];
    }
}
