<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\WpPostQueryComposingInterface;
use Pollen\WpPost\WpPostQuery as post;
use Pollen\WpPost\WpPostQueryInterface;

class ArticleFooterPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                /** @var bool */
                'enabled' => false,
                /** @var int|object|false|null */
                'post'    => null,
                'content' => null,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $content = $this->get('content');
        $post = $this->get('post');

        if (($post !== false) && ($post = $post instanceof WpPostQueryInterface ? $post : post::create($post))) {
            if ($post instanceof WpPostQueryComposingInterface) {
                $enabled = $post->getSingularComposing('enabled', []);

                if ($enabled['children']) {
                    $children = $this->partial('article-children', compact('post'))->render();
                    if ($children) {
                        $this->set(
                            [
                                'children' => $children,
                                'enabled'  => true,
                            ]
                        );
                    }
                }
            }
            $this->set(compact('enabled', 'post'));
        }
        $this->set('enabled', $this->get('enabled') || (bool)$content);

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->themeSuite()->resources('views/partial/article-footer');
    }
}
