<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Asset;

use Brain\Monkey\Functions;
use EdPittol\CursoPhpConference2025Plugin\Common\Asset\WebpackExtraction\WebpackExtractionScript;
use EdPittol\CursoPhpConference2025Plugin\Common\Filesystem\WebApplicationPublicFile;
use Mockery;
use org\bovigo\vfs\vfsStream;
use Tests\Support\UnitTestCase;

final class WebpackExtractionScriptTest extends UnitTestCase
{
    public function testEnqueue(): void
    {
        $root = vfsStream::setup('root', null, [
            'some' => [
                'entry.asset.php' => "<?php return array('dependencies' => array('react'), 'version' => '123');"
            ],
        ]);

        Functions\expect('wp_enqueue_script')
            ->once()
            ->with(
                'some-script',
                'http://url-to-webapp/some/entry.js',
                ['react'],
                '123',
                Mockery::any()
            );

        Functions\stubs([
            'wp_script_is' => false,
            'is_admin' => false,
        ]);

        $filesystemPath = $root->url() . '/';
        $webApplicationPublicFile = new WebApplicationPublicFile($filesystemPath, 'http://url-to-webapp/');

        $webpackExtractionScript = new WebpackExtractionScript(
            webApplicationPublicFile: $webApplicationPublicFile,
            entryKey: 'some/entry',
            handle: 'some-script',
        );

        $webpackExtractionScript->enqueue();
    }
}
