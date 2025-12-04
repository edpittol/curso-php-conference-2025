<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Repository;

use Exception;
use WC_Order;

class BankSlipUrlRepository
{
    public const string BANK_SLIP_URL_META_KEY = '_asaas_bank_slip_url';

    public function retrieve(WC_Order $wcOrder): string
    {
        $bankSlipUrl = $wcOrder->get_meta(self::BANK_SLIP_URL_META_KEY);

        if (!\is_string($bankSlipUrl) || $bankSlipUrl === '') {
            throw new Exception('Bank slip URL meta is missing or invalid');
        }

        return $bankSlipUrl;
    }

    public function persist(WC_Order $wcOrder, string $bankSlipUrl): void
    {
        $wcOrder->add_meta_data(self::BANK_SLIP_URL_META_KEY, $bankSlipUrl, true);
    }
}
