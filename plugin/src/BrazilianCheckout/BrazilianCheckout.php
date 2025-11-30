<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BrazilianCheckout;

use EdPittol\CursoPhpConference2025Plugin\BrazilianCheckout\Hook\CpfCheckoutField;
use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;

class BrazilianCheckout
{
    public function __construct(
        PluginService $pluginService
    ) {
        (new CpfCheckoutField($pluginService));
    }
}
