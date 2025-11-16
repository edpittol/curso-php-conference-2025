<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\DummyGateway\Hook;

use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;

class Assets
{
    public function __construct(
        private readonly PluginService $pluginService
    ) {
        add_action('wp_enqueue_scripts', $this->enqueueDummyGatewayScript(...));
    }

    public function enqueueDummyGatewayScript(): void
    {
        $script_url        = $this->pluginService->url() . '/assets/js/dummy/blocks.js';
        $script_asset_path = $this->pluginService->path() . '/assets/js/dummy/blocks.asset.php';
        $script_asset      = require($script_asset_path);

        wp_enqueue_script('dummy-gateway-blocks-script', $script_url, $script_asset['dependencies'], $script_asset['version'], ['in_footer' => true]);
    }
}
