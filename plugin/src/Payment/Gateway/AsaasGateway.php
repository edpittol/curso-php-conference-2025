<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Payment\Gateway;

use DateTimeImmutable;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use EdPittol\CursoPhpConference2025Plugin\Customer\Repository\CustomerOrderMetaRepository;
use EdPittol\CursoPhpConference2025Plugin\Payment\Api\Endpoint\PaymentEndpoint;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\ApiPayment;
use EdPittol\CursoPhpConference2025Plugin\Payment\Data\Payment;
use EdPittol\CursoPhpConference2025Plugin\Payment\Mapper\AsaasStatusToWcStatusMapper;
use EdPittol\CursoPhpConference2025Plugin\Payment\Service\PaymentApiService;
use WC_Order;
use WC_Payment_Gateway;

abstract class AsaasGateway extends WC_Payment_Gateway
{
    public function __construct(
        protected AsaasClient $asaasClient
    ) {
    }

    abstract protected function billingType(): string;

    abstract protected function dueDate(): DateTimeImmutable;

    /**
     * @param int $order_id
     * @return array{result:string, redirect:string}
     */
    // phpcs:ignore PSR1.Methods.CamelCapsMethodName -- Ignore for WooCommerce compatibility
    public function process_payment($order_id): array
    {
        $order = wc_get_order($order_id);

        if (\is_bool($order) || !is_a($order, WC_Order::class)) {
            return [
                'result' => 'failure',
                'redirect' => '',
            ];
        }

        do_action('asaas_before_process_payment', $order);

        $apiPayment = $this->createAsaasPayment($order);
        $this->updateOrderStatus($order, $apiPayment);
        $this->maybeReduceStock($order);
        $this->emptyCart();

        do_action('asaas_after_process_payment', $order, $apiPayment);

        $order->save();

        return [
            'result' => 'success',
            'redirect' => $this->get_return_url($order),
        ];
    }

    private function createAsaasPayment(WC_Order $wcOrder): ApiPayment
    {
        $paymentEndpoint = new PaymentEndpoint($this->asaasClient);
        $paymentApiService = new PaymentApiService($paymentEndpoint);

        $customerId = new CustomerOrderMetaRepository()->retrieve($wcOrder);

        $payment = new Payment(
            customer: $customerId,
            billingType: $this->billingType(),
            value: (float) $wcOrder->get_total(),
            dueDate: $this->dueDate()
        );

        return $paymentApiService->create($payment);
    }

    private function updateOrderStatus(WC_Order $wcOrder, ApiPayment $apiPayment): void
    {
        $orderStatus = new AsaasStatusToWcStatusMapper()->map($apiPayment->status);
        $wcOrder->update_status($orderStatus, 'Payment updated with Asaas.');
    }

    private function maybeReduceStock(WC_Order $wcOrder): void
    {
        $orderStatus = $wcOrder->get_status();
        if (!\in_array($orderStatus, ['cancelled', 'failed', 'refunded'], true)) {
            wc_reduce_stock_levels($wcOrder->get_id());
        }
    }

    private function emptyCart(): void
    {
        WC()->cart->empty_cart();
    }
}
