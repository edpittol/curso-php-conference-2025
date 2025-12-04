<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Adapter;

use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;

interface ApiResponseToApiPaymentAdapter
{
    /**
     * @param array{
     *     customer: string,
     *     billingType: string,
     *     value: float|int|string,
     *     dueDate: string,
     *     status: string,
     *     bankSlipUrl: ?string
     * } $apiResponse
     */
    public function adapt(array $apiResponse): ApiPayment;
}
