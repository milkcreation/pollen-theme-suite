<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Adapters;

use Pollen\ThemeSuite\ThemeSuiteProxyInterface;

interface AdapterInterface extends ThemeSuiteProxyInterface
{
    /**
     * Chargement
     *
     * @return void
     */
    public function boot(): void;
}