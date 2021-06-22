<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\WpPostQueryComposingInterface;
use Pollen\WpPost\WpPostQuery as post;
use Pollen\WpPost\WpPostQueryInterface;

class ArticleTitlePartial extends AbstractPartialDriver
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
                 * @var string $tag
                 */
                'tag'     => 'h1',
                /**
                 * @var string|null
                 */
                'content' => null,
                /**
                 * @var int|object|false|null $post
                 */
                'post'    => null,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $post = $this->get('post');

        if (($post !== false) && ($post = $post instanceof WpPostQueryInterface ? $post : post::create($post))) {
            if ($post instanceof WpPostQueryComposingInterface) {
                $enabled = array_merge($post->getSingularComposing('enabled', []), $this->get('enabled', []));
            } else {
                $enabled = $this->get('enabled', []);
            }
            $this->set(
                [
                    'before'  => $enabled['baseline'] ? $post->getBaseline() : false,
                    'content' => $post->getTitle(),
                    'after'   => $enabled['subtitle'] ? $post->getSubtitle() : false,
                    'enabled' => $enabled,
                    'post'    => $post,
                ]
            );
        }
        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->themeSuite()->resources("views/partial/article-title");
    }
}
