<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Webhook\Service;

use WC_Order;
use EdPittol\CursoPhpConference2025Plugin\Payment\Repository\PaymentOrderMetaRepository;
use InvalidArgumentException;

class WebhookPaymentService
{
    public function processEvent(string $status, string $paymentId): void
    {
        if ($status !== 'RECEIVED') {
            throw new InvalidArgumentException('I just process received payments.');
        }

        $order = (new PaymentOrderMetaRepository())->orderFromPaymentId($paymentId);

        if (!$order instanceof WC_Order) {
            throw new InvalidArgumentException(esc_html('Order not found for payment ID: ' . $paymentId));
        }

        $order->payment_complete();
    }
}
