<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Adapter;

use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;
use InvalidArgumentException;
use EdPittol\CursoPhpConference2025Plugin\Payment\Adapter\ApiResponseToApiPaymentAdapter;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Data\ApiBoletoPayment;
use DateTimeImmutable;

class ApiResponseToApiBoletoPaymentAdapter implements ApiResponseToApiPaymentAdapter
{
    public function adapt(array $apiResponse): ApiPayment
    {
        if (!isset($apiResponse['bankSlipUrl'])) {
            throw new InvalidArgumentException('bankSlipUrl is required for Boleto payments');
        }

        return new ApiBoletoPayment(
            customer: $apiResponse['customer'],
            billingType: $apiResponse['billingType'],
            value: (float) $apiResponse['value'],
            dueDate: new DateTimeImmutable($apiResponse['dueDate']),
            status: $apiResponse['status'],
            bankSlipUrl: $apiResponse['bankSlipUrl'],
        );
    }
}
