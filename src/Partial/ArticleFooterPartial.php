<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\Query\QueryPostComposingInterface;
use tiFy\Wordpress\Contracts\Query\QueryPost as QueryPostContract;
use tiFy\Wordpress\Query\QueryPost as post;

class ArticleFooterPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(parent::defaultParams(), [
            /** @var bool */
            'enabled' => false,
            /** @var int|object|false|null */
            'post'    => null,
            'content' => null,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $content = $this->get('content');

        if ($this->get('post') === false) {
            return parent::render();
        } elseif ($article = ($p = $this->get('post', null)) instanceof QueryPostContract ? $p : post::create($p)) {
            if ($article instanceof QueryPostComposingInterface) {
                $enabled = $article->getSingularComposing('enabled', []);

                if ($enabled['children']) {
                    $children = $this->partialManager()->get('article-children', ['post' => $article])->render();

                    if ($children) {
                        $this->set([
                            'children' => $children,
                            'enabled'  => true
                        ]);
                    }
                }
            }

            $this->set([
                'article' => $article,
            ]);
        }

        $this->set('enabled', $this->get('enabled') || !!$content);

        return parent::render();
    }
}
