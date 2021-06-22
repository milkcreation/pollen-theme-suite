<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Query;

use Pollen\Support\ParamsBag;

/**
 * @mixin WpPostQueryComposingInterface
 */
trait WpPostQueryComposingTrait
{
    /**
     * Instance des paramètres d'affichage des pages de flux.
     */
    protected ?ParamsBag $archiveComposing;

    /**
     * Clé de qualification de la composition des pages de flux.
     */
    protected string $archiveComposingKey = '_archive_composing';

    /**
     * Instance des paramètres d'affichage généraux.
     */
    protected ?ParamsBag $globalComposing;

    /**
     * Clé de qualification de la composition générale.
     */
    protected string $globalComposingKey = '_global_composing';

    /**
     * Instance des paramètres d'affichage de la page de contenu.
     */
    protected ?ParamsBag $singularComposing;

    /**
     * Clé de qualification de la composition d'une page de contenu.
     */
    protected string $singularComposingKey = '_singular_composing';

    /**
     * Paramètres par défaut des pages de contenu.
     */
    protected array $defaultsArchiveComposing = [];

    /**
     * Paramètres par défaut généraux.
     */
    protected array $defaultsGlobalComposing = [];

    /**
     * Paramètres par défaut des pages de contenu.
     */
    protected array $defaultsSingularComposing = [];

    /**
     * @inheritDoc
     */
    public function getArchiveComposing(?string $key = null, $default = null)
    {
        if (is_null($this->archiveComposing)) {
            $params = array_merge(
                $this->defaultsArchiveComposing,
                $this->getMetaSingle($this->archiveComposingKey, [])
            );

            $enabled = array_merge($this->getGlobalComposing('enabled', []), [
                'banner'        => true,
                'banner_format' => false,
                'excerpt'       => true,
            ], $params['enabled'] ?? []);
            array_walk($enabled, function (&$opt) {
                $opt = filter_var($opt, FILTER_VALIDATE_BOOLEAN);
            });
            $params['enabled'] = $enabled;

            $this->archiveComposing = new ParamsBag($params);
        }

        return is_null($key) ? $this->archiveComposing : $this->archiveComposing->get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public function getAltTitle(): string
    {
        return $this->getGlobalComposing('alt_title') ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getBanner(array $attrs = []): string
    {
        if (!$id = $this->getArchiveComposing('banner_img', 0)) {
            return $this->getThumbnail('composing-banner', $attrs);
        }
        if ($img = wp_get_attachment_image($id, 'composing-banner', false, $attrs)) {
            return $img;
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function getBaseline(): string
    {
        return $this->getGlobalComposing('baseline') ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getChildrenTitle(): string
    {
        return $this->getSingularComposing('children_title') ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getGlobalComposing(?string $key = null, $default = null)
    {
        if (is_null($this->globalComposing)) {
            $params = array_merge($this->defaultsGlobalComposing, $this->getMetaSingle($this->globalComposingKey, []));

            $enabled = array_merge([
                'alt_title' => true,
                'baseline'  => true,
                'subtitle'  => true,
            ], $params['enabled'] ?? []);
            array_walk($enabled, function (&$opt) {
                $opt = filter_var($opt, FILTER_VALIDATE_BOOLEAN);
            });
            $params['enabled'] = $enabled;

            $this->globalComposing = new ParamsBag($params);
        }

        return is_null($key) ? $this->globalComposing : $this->globalComposing->get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public function getHeader(array $attrs = []): string
    {
        if (!$id = $this->getSingularComposing('header_img', 0)) {
            return $this->getThumbnail('composing-header', $attrs);
        }

        if ($img = wp_get_attachment_image($id, 'composing-header', false, $attrs)) {
            return $img;
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function getRelatedTitle(): string
    {
        return $this->getSingularComposing('related_title') ?: '';
    }

    /**
     * @inheritDoc
     */
    public function getSingularComposing(?string $key = null, $default = null)
    {
        if (is_null($this->singularComposing)) {
            $params = array_merge(
                $this->defaultsSingularComposing,
                $this->getMetaSingle($this->singularComposingKey, [])
            );

            $enabled = array_merge($this->getGlobalComposing('enabled', []), [
                'children'       => true,
                'children_title' => true,
                'content'        => true,
                'header'         => false,
            ], $params['enabled'] ?? []);
            array_walk($enabled, function (&$opt) {
                $opt = filter_var($opt, FILTER_VALIDATE_BOOLEAN);
            });
            $params['enabled'] = $enabled;

            $this->singularComposing = new ParamsBag($params);
        }

        return is_null($key) ? $this->singularComposing : $this->singularComposing->get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public function getSubtitle(): string
    {
        return $this->getGlobalComposing('subtitle') ?: '';
    }
}
