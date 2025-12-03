<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Hook;

use Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Gateway\BoletoGateway;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Gateway\BoletoGatewayBlocks;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use WC_Payment_Gateway;

class Gateway
{
    public function __construct(private readonly AsaasClient $asaasClient)
    {
        add_action('woocommerce_blocks_payment_method_type_registration', $this->registerBlockPaymentMethodType(...));

        add_filter('woocommerce_payment_gateways', $this->initGateways(...));
    }

    /**
     * @param array<int, class-string|WC_Payment_Gateway> $methods
     * @return array<int, class-string|WC_Payment_Gateway>
     */
    public function initGateways(array $methods): array
    {
        $methods[] = new BoletoGateway($this->asaasClient);
        return $methods;
    }

    public function registerBlockPaymentMethodType(PaymentMethodRegistry $paymentMethodRegistry): void
    {
        $paymentMethodRegistry->register(new BoletoGatewayBlocks());
    }
}
