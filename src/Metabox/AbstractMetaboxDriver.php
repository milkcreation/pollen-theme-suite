<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox;

use Pollen\ThemeSuite\Contracts\ThemeSuiteContract;
use Pollen\ThemeSuite\ThemeSuiteAwareTrait;
use tiFy\Metabox\Contracts\MetaboxContract;
use tiFy\Metabox\MetaboxDriver;

abstract class AbstractMetaboxDriver extends MetaboxDriver implements MetaboxDriverInterface
{
    use ThemeSuiteAwareTrait;

    /**
     * @param ThemeSuiteContract $themeSuiteManager
     * @param MetaboxContract $metaboxManager
     */
    public function __construct(ThemeSuiteContract $themeSuiteManager, MetaboxContract $metaboxManager)
    {
        $this->setThemeSuite($themeSuiteManager);

        parent::__construct($metaboxManager);
    }
}
