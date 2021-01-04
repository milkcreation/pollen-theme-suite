<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox\Post\Composing;

use tiFy\Metabox\MetaboxDriverInterface;
use Pollen\ThemeSuite\Metabox\AbstractMetaboxDriver;
use WP_Post;

class GlobalMetabox extends AbstractMetaboxDriver
{
    /**
     * @inheritDoc
     */
    protected $name = '_global_composing';

    /**
     * @inheritDoc
     */
    public function boot(): MetaboxDriverInterface
    {
        parent::boot();

        add_action(
            'add_meta_boxes',
            function () {
                /** @var WP_Post|null $post */
                global $post;

                if ($post instanceof WP_Post) {
                    remove_meta_box('postimagediv', $post->post_type, 'side');
                }
            }
        );
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'baseline'  => false,
                'alt_title' => false,
                'subtitle'  => false,
                'thumbnail' => true,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Compo. générale', 'tify');
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources('views/metabox/post/composing/global');
    }
}
