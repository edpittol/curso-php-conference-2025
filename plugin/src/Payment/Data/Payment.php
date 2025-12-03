<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Data;

use DateTimeImmutable;

readonly class Payment
{
    public function __construct(
        public string $customer,
        public string $billingType,
        public float $value,
        public DateTimeImmutable $dueDate
    ) {
    }
}
