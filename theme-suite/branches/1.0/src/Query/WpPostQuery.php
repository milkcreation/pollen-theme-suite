<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Query;

use Pollen\WpPost\WpPostQuery as BaseWpPostQuery;

class WpPostQuery extends BaseWpPostQuery implements WpPostQueryComposingInterface
{
    use WpPostQueryComposingTrait;
}
