<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Service;

use EdPittol\CursoPhpConference2025Plugin\Payment\Adapter\ApiResponseToApiPaymentAdapter;
use EdPittol\CursoPhpConference2025Plugin\Payment\Api\Endpoint\PaymentEndpoint;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\Payment;

class PaymentApiService
{
    public function __construct(private readonly PaymentEndpoint $paymentEndpoint)
    {
    }

    public function create(Payment $payment): ApiPayment
    {
        $response = $this->paymentEndpoint->create($payment);

        /** @var array{
         *     customer: string,
         *     billingType: string,
         *     value: float|int|string,
         *     dueDate: string,
         *     status: string
         * } $responseBody
         */
        $responseBody = $response->decode_body();

        return new ApiResponseToApiPaymentAdapter()->adapt($responseBody);
    }
}
