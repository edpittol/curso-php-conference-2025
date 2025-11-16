<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway;

use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Hook\Assets;
use EdPittol\CursoPhpConference2025Plugin\DummyGateway\Hook\Gateway;
use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;

class DummyGateway
{
    public function __construct(
        private readonly PluginService $pluginService
    ) {
        (new Assets($this->pluginService));
        (new Gateway());
    }
}
