<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Data;

final readonly class ApiCustomer extends Customer
{
    public function __construct(
        string $name,
        string $cpfCnpj,
        string $email,
        ?string $phone,
        string $addressNumber,
        ?string $complement,
        string $postalCode,
        public string $apiId
    ) {
        parent::__construct($name, $cpfCnpj, $email, $phone, $addressNumber, $complement, $postalCode);
    }
}
