<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\BoletoGateway\Hook;

use EdPittol\CursoPhpConference2025Plugin\Common\Asset\WebpackExtraction\WebpackExtractionScript;
use EdPittol\CursoPhpConference2025Plugin\Core\Service\PluginService;

class Assets
{
    public function __construct(
        private readonly PluginService $pluginService
    ) {
        add_action('wp_enqueue_scripts', $this->enqueueBoletoGatewayScript(...));
    }

    public function enqueueBoletoGatewayScript(): void
    {
        $webpackExtractionScript = new WebpackExtractionScript(
            $this->pluginService->webApplicationPublicFile('assets/js/'),
            'boleto/blocks',
            'boleto-gateway-blocks-script',
        );

        $webpackExtractionScript->enqueue();
    }
}
