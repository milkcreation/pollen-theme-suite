<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Adapters;

use Pollen\ThemeSuite\Contracts\ThemeSuiteContract;
use Pollen\ThemeSuite\ThemeSuiteAwareTrait;

abstract class AbstractThemeSuiteAdapter implements ThemeSuiteAdapterInterface
{
    use ThemeSuiteAwareTrait;

    /**
     * Liste des portions d'affichage par défaut.
     * @var string[][]
     */
    protected $defaultPartials = [];

    /**
     * Liste des fournisseurs de services par défaut.
     * @var string[][]
     */
    protected $defaultProviders = [];

    /**
     * @param ThemeSuiteContract $themeSuiteManager
     */
    public function __construct(ThemeSuiteContract $themeSuiteManager)
    {
        $this->setThemeSuite($themeSuiteManager);
    }
}
