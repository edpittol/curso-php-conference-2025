<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Data;

use DateTimeImmutable;

readonly class ApiPayment extends Payment
{
    public function __construct(
        string $customer,
        string $billingType,
        float $value,
        DateTimeImmutable $dueDate,
        public string $status
    ) {
        parent::__construct($customer, $billingType, $value, $dueDate);
    }
}
