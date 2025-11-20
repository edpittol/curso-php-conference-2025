<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Asset;

abstract class Asset
{
    /**
     * @param string[] $dependencies
     */
    public function __construct(
        public readonly string $url,
        public readonly string $handle,
        public readonly array $dependencies = [],
        public readonly string $version = ''
    ) {
    }

    abstract public function mustBeEnqueued(): bool;

    abstract public function enqueue(): void;

    abstract public function isAlreadyEnqueued(): bool;
}
