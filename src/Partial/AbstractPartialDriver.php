<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Partial;

use Pollen\ThemeSuite\ThemeSuite as ThemeSuiteContract;
use Pollen\ThemeSuite\ThemeSuiteProxy;
use Pollen\Partial\PartialDriver;
use Pollen\Partial\PartialManagerInterface;

abstract class AbstractPartialDriver extends PartialDriver implements PartialDriverInterface
{
    use ThemeSuiteProxy;

    /**
     * @param ThemeSuiteContract $themeSuite
     * @param PartialManagerInterface $partialManager
     */
    public function __construct(ThemeSuiteContract $themeSuite, PartialManagerInterface $partialManager)
    {
        $this->setThemeSuite($themeSuite);

        parent::__construct($partialManager);
    }
}
