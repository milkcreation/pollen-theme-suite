<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Metabox;

use tiFy\Metabox\MetaboxDriver;
use Pollen\ThemeSuite\ThemeSuiteAwareTrait;

abstract class AbstractMetaboxDriver extends MetaboxDriver implements MetaboxDriverInterface
{
    use ThemeSuiteAwareTrait;
}
