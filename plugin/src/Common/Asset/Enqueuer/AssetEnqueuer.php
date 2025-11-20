<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Asset\Enqueuer;

use EdPittol\CursoPhpConference2025Plugin\Common\Asset\Asset;

/**
 * @template T of Asset
 */
abstract class AssetEnqueuer
{
    /**
     * @param T $asset
     */
    public function __construct(
        public readonly Asset $asset
    ) {
    }

    abstract public function enqueue(): void;

    protected function canEnqueue(): bool
    {
        if ($this->asset->isAlreadyEnqueued()) {
            return false;
        }

        return $this->asset->mustBeEnqueued();
    }
}
