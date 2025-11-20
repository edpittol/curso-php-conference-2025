<?php

declare(strict_types=1);

namespace EdPittol\CursoPhpConference2025Plugin\Common\Asset\Enqueuer;

use EdPittol\CursoPhpConference2025Plugin\Common\Asset\Script;

/**
 * @extends AssetEnqueuer<Script>
 */
class ScriptEnqueuer extends AssetEnqueuer
{
    public function __construct(Script $script)
    {
        parent::__construct($script);
    }

    public function enqueue(): void
    {
        if (!$this->canEnqueue()) {
            return;
        }

        wp_enqueue_script(
            $this->asset->handle,
            $this->asset->url,
            $this->asset->dependencies,
            $this->asset->version,
            [
                'in_footer' => $this->asset->inFooter,
                'strategy' => $this->asset->strategy,
            ]
        );
    }
}
