<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Data;

readonly class Customer
{
    public function __construct(
        public string $name,
        public string $cpfCnpj,
        public string $email,
        public ?string $phone,
        public string $addressNumber,
        public ?string $complement,
        public string $postalCode
    ) {
    }
}
