<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Adapter;

use DateTimeImmutable;
use InvalidArgumentException;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\Payment;
use WC_Order;

class WcOrderToPaymentAdapter
{
    public function adapt(WC_Order $wcOrder): Payment
    {
        return new Payment(
            customer: $this->cpf($wcOrder),
            billingType: 'BOLETO',
            value: (float) $wcOrder->get_total(),
            dueDate: new DateTimeImmutable('+3 days'),
        );
    }

    private function cpf(WC_Order $wcOrder): string
    {
        $cpf = $wcOrder->get_meta('_wc_other/curso-php-conference-2025/cpf');
        if (!\is_string($cpf)) {
            throw new InvalidArgumentException('CPF meta is missing or invalid');
        }

        return $cpf;
    }
}
