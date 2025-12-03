<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Mapper;

class AsaasStatusToWcStatusMapper
{
    public function map(string $asaasStatus): string
    {
        return match ($asaasStatus) {
            'PENDING' => 'pending',
            'RECEIVED', 'CONFIRMED', 'RECEIVED_IN_CASH' => 'processing',
            'OVERDUE' => 'cancelled',
            'REFUNDED' => 'refunded',
            'REFUND_REQUESTED',
            'CHARGEBACK_REQUESTED',
            'CHARGEBACK_DISPUTE',
            'AWAITING_CHARGEBACK_REVERSAL',
            'DUNNING_REQUESTED',
            'DUNNING_RECEIVED',
            'AWAITING_RISK_ANALYSIS' => 'on-hold',
            default => 'on-hold',
        };
    }
}
