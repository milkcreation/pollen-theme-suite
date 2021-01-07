<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\ThemeSuite as ThemeSuiteContract;
use Pollen\ThemeSuite\ThemeSuiteAwareTrait;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Partial\PartialDriver;

abstract class AbstractPartialDriver extends PartialDriver implements PartialDriverInterface
{
    use ThemeSuiteAwareTrait;

    /**
     * @param ThemeSuiteContract $themeSuite
     * @param PartialContract $partialManager
     */
    public function __construct(ThemeSuiteContract $themeSuite, PartialContract $partialManager)
    {
        $this->setThemeSuite($themeSuite);

        parent::__construct($partialManager);
    }
}
