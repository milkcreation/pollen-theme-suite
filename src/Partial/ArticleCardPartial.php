<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\WpPostQueryComposingInterface;
use Pollen\WpPost\WpPostQuery as post;
use Pollen\WpPost\WpPostQueryInterface;

class ArticleCardPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'excerpt' => 'teaser',
                /**
                 * @var array
                 */
                'enabled' => [
                    'excerpt'  => true,
                    'readmore' => true,
                    'title'    => true,
                    'thumb'    => true,
                ],
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
                $enabled = array_merge($post->getArchiveComposing('enabled', []), $this->get('enabled', []));

                $this->set('thumbnail', $post->getBanner());
            } else {
                $enabled = $this->get('enabled', []);
                $this->set('thumbnail', $post->getThumbnail('composing-banner'));
            }

            if (!$this->get('thumbnail') && ($this->get('holder') !== false)) {
                $holder = $this->get('holder');
                if (!is_string($holder)) {
                    $holder = $this->partial(
                        'holder',
                        array_merge(
                            [
                                'attrs'  => [
                                    'class' => '%s ArticleCard-thumbImg',
                                ],
                                'width'  => 480,
                                'height' => 270,
                            ],
                            is_array($holder) ? $holder : []
                        )
                    );
                }
                $this->set('thumbnail', $holder);
            }
            if ($this->get('readmore') !== false) {
                $readmore = $this->get('readmore');
                if (!is_string($readmore)) {
                    $readmoreConf = array_merge(
                        [
                            'attrs'   => [],
                            'content' => 'Lire la suite',
                            'tag'     => 'a',
                        ],
                        is_array($readmore) ? $readmore : []
                    );

                    if (!isset($readmoreConf['attrs']['class'])) {
                        $readmoreConf['attrs']['class'] = 'ArticleCard-readmoreLink';
                    }
                    if (!isset($readmoreConf['attrs']['href'])) {
                        $readmoreConf['attrs']['href'] = $post->getPermalink();
                    }
                    if (!isset($readmoreConf['attrs']['title'])) {
                        $readmoreConf['attrs']['title'] = sprintf('Consulter %s', $post->getTitle(true));
                    }

                    $readmore = $this->partial('tag', $readmoreConf);
                }
                $this->set(compact('readmore'));
            }
            $this->set(compact('post', 'enabled'));

            return parent::render();
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->themeSuite()->resources('views/partial/article-card');
    }
}
