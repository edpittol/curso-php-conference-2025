<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Adapter;

use EdPittol\CursoPhpConference2025Plugin\Payment\Data\Payment;

class PaymentToApiRequestAdapter
{
    /**
     * @return array{
     *     customer: string,
     *     billingType: string,
     *     value: float|int,
     *     dueDate: string
     * }
     */
    public function adapt(Payment $payment): array
    {
        return [
            'customer' => $payment->customer,
            'billingType' => $payment->billingType,
            'value' => $payment->value,
            'dueDate' => $payment->dueDate->format('Y-m-d'),
        ];
    }
}
