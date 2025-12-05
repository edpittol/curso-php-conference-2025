<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Data;

use DateTimeImmutable;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;

final readonly class ApiBoletoPayment extends ApiPayment
{
    public function __construct(
        string $customer,
        string $billingType,
        float $value,
        DateTimeImmutable $dueDate,
        string $status,
        string $apiId,
        public string $bankSlipUrl
    ) {
        parent::__construct($customer, $billingType, $value, $dueDate, $apiId, $status);
    }
}
