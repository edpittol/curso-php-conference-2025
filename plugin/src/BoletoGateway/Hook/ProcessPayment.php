<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Hook;

use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Adapter\ApiResponseToApiBoletoPaymentAdapter;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Data\ApiBoletoPayment;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Gateway\BoletoGateway;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Repository\BankSlipUrlRepository;
use EdPittol\CursoPhpConference2025Plugin\Payment\Adapter\ApiResponseToApiPaymentAdapter;
use WC_Order;

class ProcessPayment
{
    public function __construct()
    {
        add_action('asaas_after_process_payment', $this->registerBankSlipUrl(...), 10, 2);

        add_filter('asaas_payment_api_response_adapter', $this->asaasPaymentAdapter(...), 10, 2);
        add_filter('woocommerce_my_account_my_orders_actions', $this->addBankSlipUrlToMyOrdersActions(...), 10, 2);
    }

    public function registerBankSlipUrl(WC_Order $wcOrder, ApiBoletoPayment $apiBoletoPayment): void
    {
        $bankSlipUrlRepository = new BankSlipUrlRepository();
        $bankSlipUrlRepository->persist($wcOrder, $apiBoletoPayment->bankSlipUrl);
    }

    public function asaasPaymentAdapter(
        ?ApiResponseToApiPaymentAdapter $apiResponseToApiPaymentAdapter,
        string $billingType
    ): ?ApiResponseToApiPaymentAdapter {
        if ($billingType === BoletoGateway::BILLING_TYPE) {
            return new ApiResponseToApiBoletoPaymentAdapter();
        }

        return $apiResponseToApiPaymentAdapter;
    }

    /**
     * @param array<string, array{
     *     url: string,
     *     name: string,
     *     aria-label?: string
     * }> $actions
     * @return array<string, array{
     *     url: string,
     *     name: string,
     *     aria-label?: string
     * }>
     */
    public function addBankSlipUrlToMyOrdersActions(
        array $actions,
        WC_Order $wcOrder
    ): array {
        $paymentMethod = $wcOrder->get_payment_method();

        if ($paymentMethod !== BoletoGateway::GATEWAY_ID) {
            return $actions;
        }

        $bankSlipUrlRepository = new BankSlipUrlRepository();
        $bankSlipUrl = $bankSlipUrlRepository->retrieve($wcOrder);

        $actions['view-boleto'] = [
            'url'  => $bankSlipUrl,
            'name' => 'Ver Boleto',
            'aria-label' => 'Ver boleto do pedido ' . $wcOrder->get_id(),
        ];

        return $actions;
    }
}
