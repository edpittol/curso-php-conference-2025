<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Gateway;

use DateTimeImmutable;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use EdPittol\CursoPhpConference2025Plugin\Payment\Gateway\AsaasGateway;

class BoletoGateway extends AsaasGateway
{
    public $id = self::GATEWAY_ID;

    public const string GATEWAY_ID = 'boleto_gateway';

    public const string BILLING_TYPE = 'BOLETO';

    public function __construct(AsaasClient $asaasClient)
    {
        parent::__construct($asaasClient);

        $this->init_form_fields();
        $this->init_settings();

        // Actions.
        add_filter('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
    }

    protected function billingType(): string
    {
        return self::BILLING_TYPE;
    }

    protected function dueDate(): DateTimeImmutable
    {
        return new DateTimeImmutable('+3 days');
    }
}
