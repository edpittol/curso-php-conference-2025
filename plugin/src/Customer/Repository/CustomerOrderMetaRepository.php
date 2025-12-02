<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Repository;

use Exception;
use WC_Order;

class CustomerOrderMetaRepository
{
    public const string CUSTOMER_ID_META_KEY = '_asaas_customer_id';

    public function retrieve(WC_Order $wcOrder): string
    {
        $customerId = $wcOrder->get_meta(self::CUSTOMER_ID_META_KEY);

        if (!\is_string($customerId) || $customerId === '') {
            throw new Exception('Customer ID meta is missing or invalid');
        }

        return $customerId;
    }

    public function persist(WC_Order $wcOrder, string $customerId): void
    {
        $wcOrder->add_meta_data(self::CUSTOMER_ID_META_KEY, $customerId, true);
    }
}
