<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Adapter;

use EdPittol\CursoPhpConference2025Plugin\Customer\Data\ApiCustomer;

class ApiResponseToApiCustomerAdapter
{
    /**
     * Summary of adapt
     * @param array{
     *  name: string,
     *  cpfCnpj: string,
     *  email: string,
     *  phone: string,
     *  addressNumber: string,
     *  complement: string,
     *  postalCode: string,
     *  id: string,
     * } $apiResponse
     */
    public static function adapt(array $apiResponse): ApiCustomer
    {
        return new ApiCustomer(
            name: $apiResponse['name'],
            cpfCnpj: $apiResponse['cpfCnpj'],
            email: $apiResponse['email'],
            phone: $apiResponse['phone'],
            addressNumber: $apiResponse['addressNumber'],
            complement: $apiResponse['complement'],
            postalCode: $apiResponse['postalCode'],
            apiId: $apiResponse['id']
        );
    }
}
