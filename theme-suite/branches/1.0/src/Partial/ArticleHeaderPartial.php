<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\WpPostQueryComposingInterface;
use Pollen\WpPost\WpPostQuery as post;
use Pollen\WpPost\WpPostQueryInterface;

class ArticleHeaderPartial extends AbstractPartialDriver
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
                 * @var array|bool $enable
                 */
                'enabled'    => false,
                /**
                 * @var bool|array
                 */
                'breadcrumb' => true,
                /**
                 * @var int|object|false|null
                 */
                'post'       => null,
                'title'      => null,
                /**
                 * @var bool|string|null
                 */
                'content'    => null,
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $breadcrumb = $this->get('breadcrumb');
        $content = $this->get('content');
        $title = $this->get('title');
        $post = $this->get('post');

        if ($breadcrumb !== false && !is_array($breadcrumb)) {
            $this->set('breadcrumb', []);
        }

        if (($post !== false) && ($post = $post instanceof WpPostQueryInterface ? $post : post::create($post))) {
            if ($post instanceof WpPostQueryComposingInterface) {
                $enabled = $post->getSingularComposing('enabled', []);

                if ($content === null) {
                    $content = ($header = $post->getHeader()) && $enabled['header'] ? $header : false;
                }
            }
            if ($content !== false) {
                $this->set('attrs.class', $this->get('attrs.class') . ' ArticleHeader--with_content');
            }
            $title = compact('post');

            $this->set(compact('post', 'content', 'title'));
        } else {
            if ($content !== false) {
                if (($content === true) || ($content === null)) {
                    $content = '';
                }
                $this->set('attrs.class', $this->get('attrs.class') . ' ArticleHeader--with_content');
            }
            if (is_string($title)) {
                $title = [
                    'content' => $title,
                    'post'    => false,
                ];
            } elseif (is_array($title)) {
                $title = array_merge(['post' => false], $title);
            }
            $this->set(compact('content', 'title'));
        }

        $this->set('enabled', !!$this->get('enabled') || !!$breadcrumb || !!$title || !!$content);

        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->themeSuite()->resources('views/partial/article-header');
    }
}
