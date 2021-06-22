<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Column;

use Pollen\ThemeSuite\Query\QueryPost as post;

class ComposingColumn extends AbstractColumnDisplayPostTypeController
{
    /**
     * @inheritDoc
     */
    public function header()
    {
        return $this->item->getTitle() ? : __('Composition', 'theme');
    }

    /**
     * @inheritDoc
     */
    public function content($column_name = null, $post_id = null, $null = null)
    {
        return $this->viewer('index', ['post' => post::create($post_id)]);
    }
}
