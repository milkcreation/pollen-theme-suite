<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox;

class ImageGalleryMetabox extends AbstractMetaboxDriver
{
    /**
     * @inheritDoc
     */
    protected $name = 'image_gallery';

    /**
     * @inheritDoc
     */
    public function defaultParams(): array
    {
        return array_merge(
            parent::defaultParams(),
            [
                'amount'      => 9,
                'by_row'      => 3,
                /** @var array|bool */
                'media-image' => [
                    'width'  => 480,
                    'height' => 480,
                    'size'   => 'thumbnail',
                ],
                /** @var array|bool */
                'caption'     => [
                    'attrs' => [
                        'class'       => 'widefat',
                        'placeholder' => __('Légende ...', 'tify'),
                    ],
                ],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Galerie d\'image', 'tify');
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $amount = (int)$this->get('amount');
        $byRow = (int)$this->get('by_row');

        if (12 % $byRow !== 0) {
            return $this->ts()->partialManager()->get(
                'notice',
                [
                    'type'    => 'warning',
                    'content' => __('Le paramètre fourni [by_row] n\'est pas un multiple de 12', 'tify'),
                ]
            )->render();
        }

        $mediaImg = $this->get('media-image');
        $caption = $this->get('caption');
        $col = 12 / $byRow;
        $rows = (int)ceil($amount / $byRow);

        $this->set(
            [
                'media-image' => $mediaImg === false ? false : (is_array($mediaImg) ? $mediaImg : []),
                'caption'     => $caption === false ? false : (is_array($caption) ? $caption : []),
                'col'         => $col,
                'max'         => $amount,
                'rows'        => $rows,
            ]
        );
        return parent::render();
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->ts()->resources('views/metabox/image-gallery');
    }
}
