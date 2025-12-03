<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Adapter;

use DateTimeImmutable;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;

class ApiResponseToApiPaymentAdapter
{
    /**
     * @param array{
     *     customer: string,
     *     billingType: string,
     *     value: float|int|string,
     *     dueDate: string,
     *     status: string
     * } $apiResponse
     */
    public function adapt(array $apiResponse): ApiPayment
    {
        return new ApiPayment(
            customer: $apiResponse['customer'],
            billingType: $apiResponse['billingType'],
            value: (float) $apiResponse['value'],
            dueDate: new DateTimeImmutable($apiResponse['dueDate']),
            status: $apiResponse['status']
        );
    }
}
