<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Api\Endpoint;

use EdPittol\CursoPhpConference2025Plugin\Payment\Adapter\PaymentToApiRequestAdapter;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\Payment;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasEndpoint;
use WpOrg\Requests\Response;

class PaymentEndpoint extends AsaasEndpoint
{
    protected function resourcePath(): string
    {
        return 'payments';
    }

    public function create(Payment $payment): Response
    {
        $endpoint = $this->resourcePath();
        $requestData = new PaymentToApiRequestAdapter()->adapt($payment);

        return $this->asaasClient->post($endpoint, $requestData);
    }
}
