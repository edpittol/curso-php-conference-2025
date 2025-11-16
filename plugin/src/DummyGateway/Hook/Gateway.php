<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Hook;

use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway\DummyGateway;
use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway\DummyGatewayBlocks;

class Gateway
{
    public function __construct()
    {
        add_action('woocommerce_payment_gateways', $this->initGateways(...));
        add_action('woocommerce_blocks_payment_method_type_registration', $this->registerBlockPaymentMethodType(...));
    }

    public function initGateways(array $methods): array
    {
        $methods[] = DummyGateway::class;
        return $methods;
    }

    public function registerBlockPaymentMethodType($registry): void
    {
        $registry->register(new DummyGatewayBlocks());
    }
}
