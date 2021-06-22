<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite\Adapters;

use Pollen\ThemeSuite\ThemeSuiteInterface;
use Pollen\ThemeSuite\ThemeSuiteProxy;

abstract class AbstractThemeSuiteAdapter implements AdapterInterface
{
    use ThemeSuiteProxy;

    /**
     * Liste des portions d'affichage par défaut.
     */
    protected array $defaultPartials = [];

    /**
     * Liste des fournisseurs de services par défaut.
     */
    protected array $defaultProviders = [];

    /**
     * @param ThemeSuiteInterface $themeSuite
     */
    public function __construct(ThemeSuiteInterface $themeSuite)
    {
        $this->setThemeSuite($themeSuite);
    }

    /**
     * @inheritDoc
     */
    abstract public function boot(): void;
}
