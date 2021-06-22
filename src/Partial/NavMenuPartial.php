<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\Partial\Drivers\TagDriverInterface;

class NavMenuPartial extends AbstractPartialDriver
{
    /**
     * @inheritDoc
     */
    public function parseParams(): void
    {
        parent::parseParams();

        if ($items = $this->get('items')) {
            $this->set('items', array_map(function ($item) {
                $_item = [];
                $_item['tag'] = $item['tag'] ?? 'li';

                $_item['attrs'] = $item['attrs'] ?? [];

                $_item['attrs']['class'] = ($class = $_item['attrs']['class'] ?? '')
                    ? sprintf('%s NavMenu-item', $class) : 'NavMenu-item';

                if (!$content = $item['content'] ?? null) {
                    $href = $item['url'] ?? '#';
                    $content = $item['label'] ?? '';
                    $title = $item['title'] ?? basename($href);

                    $_item['content'] = $this->partial('tag', [
                        'attrs' => [
                            'class' => 'NavMenu-itemLink',
                            'href'  => $href,
                            'title' => $title
                        ],
                        'content' => $content,
                        'tag' => 'a'
                    ]);
                } elseif ($content instanceof TagDriverInterface) {
                    $content->set('attrs.class', ($class = $content->get('attrs.class'))
                        ? sprintf('%s NavMenu-itemLink', $class) : 'NavMenu-itemLink');

                    $_item['content'] = $content;
                } elseif (is_string($content)) {
                    $_item['content'] = $content;
                }

                return $_item;
            }, $items));
        }
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->themeSuite()->resources('views/partial/nav-menu');
    }
}
