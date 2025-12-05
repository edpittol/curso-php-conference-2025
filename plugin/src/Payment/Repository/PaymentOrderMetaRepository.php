<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Repository;

use Exception;
use WC_Order;

class PaymentOrderMetaRepository
{
    public const string PAYMENT_ID_META_KEY = '_asaas_payment_id';

    public function retrieve(WC_Order $wcOrder): string
    {
        $paymentId = $wcOrder->get_meta(self::PAYMENT_ID_META_KEY);
        if (!\is_string($paymentId) || $paymentId === '') {
            throw new Exception('Payment ID meta is missing or invalid');
        }

        return $paymentId;
    }

    public function persist(WC_Order $wcOrder, string $paymentId): void
    {
        $wcOrder->add_meta_data(self::PAYMENT_ID_META_KEY, $paymentId, true);
    }

    public function orderFromPaymentId(string $paymentId): ?WC_Order
    {
        $args = [
            'limit' => 1,
            'meta_key' => self::PAYMENT_ID_META_KEY,
            'meta_value' => $paymentId,
            'return' => 'objects',
        ];

        $orders = wc_get_orders($args);
        if (empty($orders)) {
            return null;
        }

        return $orders[0];
    }
}
