<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\QueryPostComposingInterface;
use tiFy\Wordpress\Contracts\Query\QueryPost as QueryPostContract;
use tiFy\Wordpress\Query\QueryPost as post;

class ArticleCardPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
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
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $post = $this->get('post');

        if (($post !== false) && ($post = $post instanceof QueryPostContract ? $post : post::create($post))) {
            if ($post instanceof QueryPostComposingInterface) {
                $enabled = array_merge($post->getArchiveComposing('enabled', []), $this->get('enabled', []));

                $this->set('thumbnail', $post->getBanner());
            } else {
                $enabled = $this->get('enabled', []);
                $this->set('thumbnail', $post->getThumbnail('composing-banner'));
            }

            if (!$this->get('thumbnail') && ($this->get('holder') !== false)) {
                $holder = $this->get('holder', null);
                if (!is_string($holder)) {
                    $holder = $this->partialManager()->get('holder', array_merge([
                        'attrs'  => [
                            'class' => '%s ArticleCard-thumbImg',
                        ],
                        'width'  => 480,
                        'height' => 270,
                    ], is_array($holder) ? $holder : []));
                }
                $this->set('thumbnail', $holder);
            }
            if ($this->get('readmore') !== false) {
                $readmore = $this->get('readmore', null);
                if (!is_string($readmore)) {
                    $readmoreConf = array_merge([
                        'attrs'   => [],
                        'content' => __('Lire la suite', 'tify'),
                        'tag'     => 'a',
                    ], is_array($readmore) ? $readmore : []);

                    if (!isset($readmoreConf['attrs']['class'])) {
                        $readmoreConf['attrs']['class'] = 'ArticleCard-readmoreLink';
                    }
                    if (!isset($readmoreConf['attrs']['href'])) {
                        $readmoreConf['attrs']['href'] = $post->getPermalink();
                    }
                    if (!isset($readmoreConf['attrs']['title'])) {
                        $readmoreConf['attrs']['title'] = sprintf(__('Consulter %s', 'tify'), $post->getTitle(true));
                    }

                    $readmore = $this->partialManager()->get('tag', $readmoreConf);
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
        return $this->ts()->resources("views/partial/article-card");
    }
}
