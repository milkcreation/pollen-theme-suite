<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\QueryPostComposingInterface;
use tiFy\Wordpress\Contracts\Query\QueryPost as QueryPostContract;
use tiFy\Wordpress\Query\QueryPost as post;

class ArticleChildrenPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'enabled'    => [
                'children' => true
            ],
            'post'       => null,
            'per_page'   => -1,
            'paged'      => 1,
            'query_args' => [],
            'title'      => __('Autre contenu en relation', 'tify'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if ($article = ($p = $this->get('post', null)) instanceof QueryPostContract ? $p : post::create($p)) {
            if (!$article->isHierarchical()) {
                return '';
            }

            if ($article instanceof QueryPostComposingInterface) {
                $enabled = array_merge($article->getSingularComposing('enabled', []), $this->get('enabled', []));
            } else  {
                $enabled = $this->get('enabled', []);
            }

            if (!$enabled['children']) {
                return '';
            }

            if (!$items = $article->getChildren($this->get('per_page'), $this->get('paged'), array_merge(
                ['orderby' => ['menu_order' => 'ASC']],
                $this->get('query_args', [])
            ))) {
                return '';
            }

            $this->set([
                'article' => $article,
                'items'   => $items,
                'enabled' => $enabled
            ]);

            return parent::render();
        }

        return '';
    }
}
