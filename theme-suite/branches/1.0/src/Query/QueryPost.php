<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Query;

use tiFy\Wordpress\Query\QueryPost as BaseQueryPost;

class QueryPost extends BaseQueryPost implements QueryPostComposingInterface
{
    use QueryPostComposingTrait;
}
