<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Customer;

use EdPittol\CursoPhpConference2025Plugin\Customer\Hook\ProcessPayment;
use EdPittol\CursoPhpConference2025Plugin\Customer\Service\CustomerOrderService;

class Customer
{
    public function __construct(CustomerOrderService $customerOrderService)
    {
        (new ProcessPayment($customerOrderService));
    }
}
