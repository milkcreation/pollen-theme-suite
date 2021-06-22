<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\Partial\PartialDriverInterface as BasePartialDriverInterface;
use Pollen\ThemeSuite\ThemeSuiteProxyInterface;

interface PartialDriverInterface extends BasePartialDriverInterface, ThemeSuiteProxyInterface
{
}
