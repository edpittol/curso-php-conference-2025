<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Core\Service;

class PluginService
{
    public function path(): string
    {
        return plugin_dir_path($this->pluginMainFile());
    }

    private function pluginMainFile(): string
    {
        return __DIR__ . '/../../../curso-php-conference-2025.php';
    }

    public function url(): string
    {
        return plugin_dir_url($this->pluginMainFile());
    }
}
