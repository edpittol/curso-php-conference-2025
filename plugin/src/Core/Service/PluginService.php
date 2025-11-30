<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Core\Service;

use RuntimeException;
use EdPittol\CursoPhpConference2025Plugin\Common\Filesystem\WebApplicationPublicFile;

class PluginService
{
    public function path(): string
    {
        return plugin_dir_path($this->pluginMainFile());
    }

    private function pluginMainFile(): string
    {
        return dirname(__DIR__, 3) . '/curso-php-conference-2025.php';
    }

    public function url(): string
    {
        return plugin_dir_url($this->pluginMainFile());
    }

    public function webApplicationPublicFile(string $path): WebApplicationPublicFile
    {
        $filePath = rtrim($this->path(), '/') . '/' . ltrim($path, '/');
        if (!file_exists($filePath)) {
            throw new RuntimeException(esc_html(sprintf('The path %s does not exist.', $filePath)));
        }

        return new WebApplicationPublicFile(
            $this->path() . $path,
            $this->url() . $path
        );
    }

    public function slug(): string
    {
        return 'curso-php-conference-2025';
    }
}
