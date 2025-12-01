<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient;

abstract class AsaasEndpoint
{
    public function __construct(
        protected AsaasClient $asaasClient
    ) {
    }

    abstract protected function resourcePath(): string;
}
