<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Hook;

use EdPittol\CursoPhpConference2025Plugin\Customer\Service\CustomerOrderService;
use WC_Order;

class ProcessPayment
{
    public function __construct(private readonly CustomerOrderService $customerOrderService)
    {
        add_action('dummy_gateway_process_payment', $this->storeAsaasCustomerIdInOrder(...));
    }

    public function storeAsaasCustomerIdInOrder(WC_Order $wcOrder): void
    {
        $this->customerOrderService->storeAsaasCustomerId($wcOrder);
    }
}
