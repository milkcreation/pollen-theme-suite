<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\QueryPostComposingInterface;
use tiFy\Wordpress\Contracts\Query\QueryPost as QueryPostContract;
use tiFy\Wordpress\Query\QueryPost as post;

class ArticleTitlePartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            'tag'     => 'h1',
            'content' => null,
            /**
             * @var int|object|false|null
             */
            'post'    => null,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if ($this->get('post') === false) {
            return parent::render();
        } elseif ($article = ($p = $this->get('post', null)) instanceof QueryPostContract ? $p : post::create($p)) {
            if ($article instanceof QueryPostComposingInterface) {
                $enabled = array_merge($article->getSingularComposing('enabled', []), $this->get('enabled', []));
            } else {
                $enabled = $this->get('enabled', []);
            }

            $this->set([
                'article' => $article,
                'before'  => $enabled['baseline'] ? $article->getBaseline() : false,
                'content' => $article->getTitle(),
                'after'   => $enabled['subtitle'] ? $article->getSubtitle() : false,
                'enabled' => $enabled
            ]);

            return parent::render();
        }

        return '';
    }
}
