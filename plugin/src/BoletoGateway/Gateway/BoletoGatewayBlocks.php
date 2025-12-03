<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Gateway;

use RuntimeException;
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

class BoletoGatewayBlocks extends AbstractPaymentMethodType
{
    protected $name = BoletoGateway::GATEWAY_ID;

    public function initialize(): void
    {
        $settings = get_option('woocommerce_boleto_gateway_settings', []);
        if (!is_array($settings)) {
            throw new RuntimeException('Invalid settings for Boleto Gateway Blocks.');
        }

        $this->settings = $settings;
    }

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function is_active(): bool
    {
        return ( $this->settings['enabled'] ?? 'no' ) === 'yes';
    }

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function get_payment_method_script_handles(): array
    {
        return [ 'boleto-gateway-blocks-script' ];
    }

    /**
     * @return array<string, string>
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function get_payment_method_data(): array
    {
        return [
            'title'       => 'Boleto Payment',
            'description' => 'Test transactions using the boleto gateway.',
        ];
    }
}
