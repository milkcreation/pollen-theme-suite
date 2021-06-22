<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite;

interface ThemeSuiteProxyInterface
{
    /**
     * Récupération de l'instance de l'application.
     *
     * @return ThemeSuite
     */
    public function themeSuite(): ThemeSuiteInterface;

    /**
     * Définition de l'application.
     *
     * @param ThemeSuiteInterface $themeSuite
     *
     * @return void
     */
    public function setThemeSuite(ThemeSuiteInterface $themeSuite): void;
}
