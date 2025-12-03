<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway;

use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Hook\Assets;
use EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Hook\Gateway;
use EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\AsaasClient;
use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;

class BoletoGateway
{
    public function __construct(
        private readonly PluginService $pluginService,
        private readonly AsaasClient $asaasClient
    ) {
        (new Assets($this->pluginService));
        (new Gateway($this->asaasClient));
    }
}
