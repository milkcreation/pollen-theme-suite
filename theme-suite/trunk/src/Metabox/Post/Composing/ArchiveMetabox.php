<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox\Post\Composing;

use Pollen\ThemeSuite\Metabox\AbstractMetaboxDriver;

class ArchiveMetabox extends AbstractMetaboxDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaults(), [
            'banner'        => true,
            'banner_format' => false,
            'excerpt'       => true,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return array_merge(parent::defaults(), [
            'name'  => '_archive_composing',
            'title' => __('Compo. page de flux', 'tify'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources('views/metabox/post/composing/archive');
    }
}
