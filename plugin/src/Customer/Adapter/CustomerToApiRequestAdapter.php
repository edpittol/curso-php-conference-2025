<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Adapter;

use EdPittol\CursoPhpConference2025Plugin\Customer\Data\Customer;

class CustomerToApiRequestAdapter
{
    /**
     * @return array{
     *   name: string,
     *   cpfCnpj: string,
     *   email: string,
     *   phone: ?string,
     *   postalCode: string,
     *   addressNumber: string,
     *   complement: ?string
     * }
     */
    public static function adapt(Customer $customer): array
    {
        return [
            'name' => $customer->name,
            'cpfCnpj' => $customer->cpfCnpj,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'postalCode' => $customer->postalCode,
            'addressNumber' => $customer->addressNumber,
            'complement' => $customer->complement,
        ];
    }
}
