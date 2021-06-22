<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\WpPostQueryComposingInterface;
use Pollen\WpPost\WpPostQuery as post;
use Pollen\WpPost\WpPostQueryInterface;

class ArticleBodyPartial extends AbstractPartialDriver
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
                'enabled'        => [
                    'content' => true,
                ],
                /**
                 * @var bool
                 */
                'content-editor' => false,
                /**
                 * @var int|object|false|null $post
                 */
                'post'           => null,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $post = $this->get('post');

        if (($post !== false) && $post = $post instanceof WpPostQueryInterface ? $post : post::create($post)) {
            if ($post instanceof WpPostQueryComposingInterface) {
                $enabled = array_merge($post->getSingularComposing('enabled', []), $this->get('enabled', []));
            } else {
                $enabled = $this->get('enabled', []);
            }
            $this->set(
                [
                    'content-editor' => true,
                    'content'        => $enabled['content'] ? trim($post->getContent()) : '',
                    'enabled'        => $enabled,
                    'post'           => $post,
                ]
            );
        } else {
            $this->set(
                [
                    'content' => $this->get('content'),
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
        return $this->themeSuite()->resources('views/partial/article-body');
    }
}
