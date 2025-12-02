<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Service;

use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use EdPittol\CursoPhpConference2025Plugin\Customer\Adapter\WcOrderToCustomerAdapter;
use EdPittol\CursoPhpConference2025Plugin\Customer\Api\Endpoint\CustomerEndpoint;
use EdPittol\CursoPhpConference2025Plugin\Customer\Repository\CustomerOrderMetaRepository;
use WC_Order;

class CustomerOrderService
{
    public function __construct(private readonly AsaasClient $asaasClient)
    {
    }

    public function storeAsaasCustomerId(WC_Order $wcOrder): void
    {
        $customerEndpoint = new CustomerEndpoint($this->asaasClient);
        $customerApiService = new CustomerApiService($customerEndpoint);

        $customer = new WcOrderToCustomerAdapter()->adapt($wcOrder);

        $apiCustomer = $customerApiService->retriveOrCreate($customer);

        new CustomerOrderMetaRepository()->persist($wcOrder, $apiCustomer->apiId);
    }
}
