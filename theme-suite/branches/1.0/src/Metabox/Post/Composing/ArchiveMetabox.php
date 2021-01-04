<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox\Post\Composing;

use Pollen\ThemeSuite\Metabox\AbstractMetaboxDriver;

class ArchiveMetabox extends AbstractMetaboxDriver
{
    /**
     * @inheritDoc
     */
    protected $name = '_archive_composing';

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'banner'        => true,
                'banner_format' => false,
                'excerpt'       => true,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Compo. page de flux', 'tify');
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources('views/metabox/post/composing/archive');
    }
}
