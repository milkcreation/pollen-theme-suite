<?php

declare(strict_types=1);

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
        return array_merge(
            parent::defaultParams(),
            [
                /**
                 * @var array
                 */
                'enabled'    => [
                    'children' => true,
                ],
                /**
                 * @var int|object|false|null $post
                 */
                'post'       => null,
                'per_page'   => -1,
                'paged'      => 1,
                'query_args' => [],
                'title'      => __('Autre contenu en relation', 'tify'),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $post = $this->get('post');

        if (($post !== false) && ($post = $post instanceof QueryPostContract ? $post : post::create($post))) {
            if (!$post->isHierarchical()) {
                return '';
            }
            if ($post instanceof QueryPostComposingInterface) {
                $enabled = array_merge($post->getSingularComposing('enabled', []), $this->get('enabled', []));
            } else {
                $enabled = $this->get('enabled', []);
            }
            if (!$enabled['children']) {
                return '';
            }
            if (!$children = $post->getChildren(
                $this->get('per_page'),
                $this->get('paged'),
                array_merge(
                    ['orderby' => ['menu_order' => 'ASC']],
                    $this->get('query_args', [])
                )
            )) {
                return '';
            }
            $this->set(compact('children', 'enabled', 'post'));

            return parent::render();
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources("views/partial/article-children");
    }
}
