<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Filesystem;

class WebApplicationPublicFile
{
    public function __construct(
        public readonly string $path,
        public readonly string $url,
    ) {
    }
}
