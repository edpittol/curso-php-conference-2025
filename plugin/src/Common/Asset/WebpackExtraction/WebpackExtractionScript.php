<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Asset\WebpackExtraction;

use RuntimeException;
use EdPittol\CursoPhpConference2025Plugin\Common\Asset\Script;
use EdPittol\CursoPhpConference2025Plugin\Common\Filesystem\WebApplicationPublicFile;

class WebpackExtractionScript extends Script
{
    public function __construct(
        private readonly WebApplicationPublicFile $webApplicationPublicFile,
        public readonly string $entryKey,
        string $handle
    ) {
        $assetMetadata = $this->loadAssetMetadata();

        parent::__construct(
            sprintf('%s%s.js', $webApplicationPublicFile->url, $entryKey),
            $handle,
            $assetMetadata['dependencies'],
            $assetMetadata['version']
        );
    }

    /**
     * @return array{dependencies: array<string>, version: string}
     */
    private function loadAssetMetadata(): array
    {
        $scriptAssetPath = $this->webApplicationPublicFile->path . $this->entryKey . '.asset.php';
        $scriptAsset     = require($scriptAssetPath);

        if (!is_array($scriptAsset)) {
            throw new RuntimeException(
                esc_html(sprintf('The asset file "%s" must return an array.', $scriptAssetPath))
            );
        }

        if (!isset($scriptAsset['dependencies'], $scriptAsset['version'])) {
            throw new RuntimeException(
                esc_html(
                    sprintf(
                        'The asset file "%s" must contain both "dependencies" and "version" keys.',
                        $scriptAssetPath
                    )
                )
            );
        }

        if (!is_array($scriptAsset['dependencies'])) {
            throw new RuntimeException(
                esc_html(sprintf('The asset file "%s" must return an array for dependencies.', $scriptAssetPath))
            );
        }

        foreach ($scriptAsset['dependencies'] as $dependency) {
            if (!is_string($dependency)) {
                throw new RuntimeException(
                    esc_html(sprintf('The asset file "%s" must contain only string dependencies.', $scriptAssetPath))
                );
            }
        }

        if (!is_string($scriptAsset['version'])) {
            throw new RuntimeException(
                esc_html(sprintf('The asset file "%s" must return a string for version.', $scriptAssetPath))
            );
        }

        /** @var array<string> $dependencies */
        $dependencies = array_values($scriptAsset['dependencies']);

        return [
            'dependencies' => $dependencies,
            'version'      => $scriptAsset['version'],
        ];
    }

    public function mustBeEnqueued(): bool
    {
        return !is_admin();
    }
}
