<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Gateway;

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

class DummyGatewayBlocks extends AbstractPaymentMethodType
{
    protected $name = DummyGateway::GATEWAY_ID;

    public function initialize(): void
    {
        $this->settings = get_option('woocommerce_dummy_gateway_settings', []);
    }

    public function is_active()
    {
        return ( $this->settings['enabled'] ?? 'no' ) === 'yes';
    }

    public function get_payment_method_script_handles()
    {
        return [ 'dummy-gateway-blocks-script' ];
    }

    public function get_payment_method_data()
    {
        return [
            'title'       => 'Dummy Payment',
            'description' => 'Test transactions using the dummy gateway.',
        ];
    }
}
