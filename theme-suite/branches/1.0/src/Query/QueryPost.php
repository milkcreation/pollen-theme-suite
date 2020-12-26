<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Query;

use tiFy\Wordpress\Query\QueryPost as BaseQueryPost;
use Pollen\ThemeSuite\Contracts\QueryPostComposing;

class QueryPost extends BaseQueryPost implements QueryPostComposing
{
    use QueryPostComposingTrait;
}
