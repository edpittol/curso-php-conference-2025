<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Service;

use EdPittol\CursoPhpConference2025Plugin\Customer\Adapter\ApiResponseToApiCustomerAdapter;
use EdPittol\CursoPhpConference2025Plugin\Customer\Api\Endpoint\CustomerEndpoint;
use EdPittol\CursoPhpConference2025Plugin\Customer\Data\ApiCustomer;
use EdPittol\CursoPhpConference2025Plugin\Customer\Data\Customer;
use Exception;

class CustomerApiService
{
    public function __construct(
        private readonly CustomerEndpoint $customerEndpoint
    ) {
    }

    public function retriveOrCreate(Customer $customer): ApiCustomer
    {
        $apiCustomer = $this->findByCpfCnpj($customer->cpfCnpj);

        if ($apiCustomer instanceof ApiCustomer) {
            return $apiCustomer;
        }

        $response = $this->customerEndpoint->create($customer);

        /**
         * @var array{
         *     name: string,
         *     cpfCnpj: string,
         *     email: string,
         *     phone: string,
         *     addressNumber: string,
         *     complement: string,
         *     postalCode: string,
         *     id: string
         * } $customerData
         */
        $customerData = $response->decode_body();

        return new ApiResponseToApiCustomerAdapter()->adapt($customerData);
    }

    public function findByCpfCnpj(string $cpfCnpj): ?ApiCustomer
    {
        $response = $this->customerEndpoint->list([
            'cpfCnpj' => $cpfCnpj,
        ]);

        $responseBody = $response->decode_body();

        $totalCount = $responseBody['totalCount'] ?? 0;

        if ($totalCount > 1) {
            throw new Exception('Multiple customers found with the same CPF/CNPJ.');
        }

        if ($totalCount === 0) {
            return null;
        }

        assert(
            isset($responseBody['data']) && \is_array($responseBody['data']),
            'Invalid response structure: missing data field.'
        );

        assert(
            isset($responseBody['data'][0]) && \is_array($responseBody['data'][0]),
            'Invalid response structure: data field does not contain customer information.'
        );

        /**
         * @var array{
         *     name: string,
         *     cpfCnpj: string,
         *     email: string,
         *     phone: string,
         *     addressNumber: string,
         *     complement: string,
         *     postalCode: string,
         *     id: string
         * } $customerData
         */
        $customerData = $responseBody['data'][0];

        return new ApiResponseToApiCustomerAdapter()->adapt($customerData);
    }
}
