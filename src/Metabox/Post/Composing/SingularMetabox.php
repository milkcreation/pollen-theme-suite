<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox\Post\Composing;

use Pollen\ThemeSuite\Metabox\AbstractMetaboxDriver;

class SingularMetabox extends AbstractMetaboxDriver
{
    /**
     * @inheritDoc
     */
    protected $name = '_singular_composing';

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'header'         => true,
                'children'       => false,
                'children_title' => false,
                'children_edit'  => false,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Compo. page de contenu', 'tify');
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources('views/metabox/post/composing/singular');
    }
}
