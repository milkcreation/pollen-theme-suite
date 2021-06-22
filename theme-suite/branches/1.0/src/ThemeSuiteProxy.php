<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite;

use Pollen\Support\ProxyResolver;
use RuntimeException;

trait ThemeSuiteProxy
{
    private ?ThemeSuiteInterface $themeSuite;

    /**
     * Récupération de l'instance de l'application.
     *
     * @return ThemeSuite
     */
    public function themeSuite(): ThemeSuiteInterface
    {
        if ($this->themeSuite === null) {
            try {
                $this->themeSuite = ThemeSuite::getInstance();
            } catch (RuntimeException $e) {
                $this->themeSuite = ProxyResolver::getInstance(
                    ThemeSuiteInterface::class,
                    ThemeSuite::class,
                    method_exists($this, 'getContainer') ? $this->getContainer() : null
                );
            }
        }

        return $this->themeSuite;
    }

    /**
     * Définition de l'application.
     *
     * @param ThemeSuiteInterface $themeSuite
     *
     * @return void
     */
    public function setThemeSuite(ThemeSuiteInterface $themeSuite): void
    {
        $this->themeSuite = $themeSuite;
    }
}
