<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Webhook;

use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;
use EdPittol\CursoPhpConference2025Plugin\Webhook\Hook\WebhookEndpoint;

class Webhook
{
    public function __construct(
        private readonly PluginService $pluginService
    ) {
        (new WebhookEndpoint($this->pluginService));
    }
}
