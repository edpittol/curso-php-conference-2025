<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Service;

use RuntimeException;
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
         *     status: string,
         *     bankSlipUrl: ?string
         * } $responseBody
         */
        $responseBody = $response->decode_body();

        /**
         * @param mixed  $adapter
         * @param string $billingType
         *
         * @return ?ApiResponseToApiPaymentAdapter
         */
        $adapter = apply_filters('asaas_payment_api_response_adapter', null, $responseBody['billingType']);

        if (!$adapter instanceof ApiResponseToApiPaymentAdapter) {
            throw new RuntimeException(
                esc_html(
                    'No valid API response to API payment adapter found for billing type ' .
                    $responseBody['billingType']
                )
            );
        }

        return $adapter->adapt($responseBody);
    }
}
