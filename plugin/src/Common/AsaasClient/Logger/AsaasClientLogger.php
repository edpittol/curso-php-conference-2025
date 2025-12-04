<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\AsaasClient\Logger;

use WC_Logger_Interface;

class AsaasClientLogger
{
    public function __construct(
        private readonly WC_Logger_Interface $wcLogger
    ) {
    }

    /**
     * @param array<string,mixed> $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->wcLogger->info($message, $this->context($context));
    }

    /**
     * @param array<string,mixed> $context
     */
    public function error(string $message, array $context = []): void
    {
        $this->wcLogger->error($message, $this->context($context));
    }

    /**
     * @param array<string,mixed> $context
     * @return array<string,mixed>
     */
    private function context(array $context): array
    {
        return array_merge(['source' => 'curso-php-conference-2025'], $context);
    }
}
