<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Asset;

use EdPittol\CursoPhpConference2025Plugin\Common\Asset\Enqueuer\ScriptEnqueuer;

abstract class Script extends Asset
{
    /**
     * @param string[]             $dependencies
     * @param array<string, mixed> $data
     */
    public function __construct(
        string $url,
        string $handle,
        array $dependencies = [],
        string $version = '',
        public readonly bool $inFooter = false,
        public readonly string $strategy = '',
        public readonly array $data = [],
    ) {
        parent::__construct($url, $handle, $dependencies, $version);
    }

    protected function enqueuer(): ScriptEnqueuer
    {
        return new ScriptEnqueuer($this);
    }

    public function enqueue(): void
    {
        $this->enqueuer()->enqueue();
    }

    public function isAlreadyEnqueued(): bool
    {
        return wp_script_is($this->handle, 'enqueued');
    }
}
