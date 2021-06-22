<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Adapters;

use RuntimeException;

class WordpressAdapter extends AbstractThemeSuiteAdapter
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        if (!function_exists('add_action')) {
            throw new RuntimeException('Wordpress add_action function is missing.');
        }

        add_action('init', function () {
            add_image_size('composing-header', 1920, 999999, false);
            // add_image_size('composing-header-lg', 1140, 641, false);
            // add_image_size('composing-header-md', 960, 540, false);
            // add_image_size('composing-header-sm', 720, 405, false);
            // add_image_size('composing-header-xs', 540, 304, false);
            add_image_size('composing-banner', 640, 999999, false);
            // add_image_size('composing-banner-lg', 460, 259, false);
            // add_image_size('composing-banner-md', 290, 163, false);
        });
    }
}
