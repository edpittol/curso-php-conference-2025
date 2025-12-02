<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer\Adapter;

use InvalidArgumentException;
use EdPittol\CursoPhpConference2025Plugin\Customer\Data\Customer;
use WC_Order;

class WcOrderToCustomerAdapter
{
    public function adapt(WC_Order $wcOrder): Customer
    {
        return new Customer(
            name: $wcOrder->get_billing_first_name() . ' ' . $wcOrder->get_billing_last_name(),
            cpfCnpj: $this->cpf($wcOrder),
            email: $wcOrder->get_billing_email(),
            phone: $wcOrder->get_billing_phone(),
            addressNumber: $this->addressNumber($wcOrder),
            complement: $wcOrder->get_billing_address_2(),
            postalCode: $wcOrder->get_billing_postcode()
        );
    }

    private function cpf(WC_Order $wcOrder): string
    {
        $cpf = $wcOrder->get_meta('_wc_other/curso-php-conference-2025/cpf');
        if (!\is_string($cpf)) {
            throw new InvalidArgumentException('CPF meta is missing or invalid');
        }

        return $cpf;
    }

    private function addressNumber(WC_Order $wcOrder): string
    {
        $address = $wcOrder->get_billing_address_1();
        $lastSpacePosition = strrpos($address, ' ');
        if ($lastSpacePosition !== false && $lastSpacePosition < \strlen($address) - 1) {
            $addressNumber = trim(substr($address, $lastSpacePosition + 1));
        }

        return $addressNumber ?? '';
    }
}
