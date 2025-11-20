<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway;

use RuntimeException;
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

class DummyGatewayBlocks extends AbstractPaymentMethodType
{
    protected $name = DummyGateway::GATEWAY_ID;

    public function initialize(): void
    {
        $settings = get_option('woocommerce_dummy_gateway_settings', []);
        if (!is_array($settings)) {
            throw new RuntimeException('Invalid settings for Dummy Gateway Blocks.');
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
        return [ 'dummy-gateway-blocks-script' ];
    }

    /**
     * @return array<string, string>
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function get_payment_method_data(): array
    {
        assert(\is_string($this->settings['title']));
        assert(\is_string($this->settings['description']));

        return [
            'title'       => $this->settings['title'],
            'description' => $this->settings['description'],
        ];
    }
}
