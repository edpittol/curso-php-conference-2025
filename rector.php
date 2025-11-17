<?php

use Rector\Config\RectorConfig;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/plugin/curso-php-conference-2025.php',
        __DIR__ . '/tests/EndToEnd',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        rectorPreset: true,
    )
    ->withPhpSets(
        php84: true
    )
    ->withImportNames(
        importShortClasses: true,
        removeUnusedImports: true
    )
;
