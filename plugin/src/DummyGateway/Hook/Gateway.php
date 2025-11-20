<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Hook;

use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;
use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway\DummyGateway;
use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway\DummyGatewayBlocks;

class Gateway
{
    public function __construct()
    {
        add_action('woocommerce_blocks_payment_method_type_registration', $this->registerBlockPaymentMethodType(...));

        add_filter('woocommerce_payment_gateways', $this->initGateways(...));
    }

    /**
     * @param array<int, class-string> $methods
     * @return array<int, class-string>
     */
    public function initGateways(array $methods): array
    {
        $methods[] = DummyGateway::class;
        return $methods;
    }

    public function registerBlockPaymentMethodType(PaymentMethodRegistry $paymentMethodRegistry): void
    {
        $paymentMethodRegistry->register(new DummyGatewayBlocks());
    }
}
