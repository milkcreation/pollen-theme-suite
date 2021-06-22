<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite;

use Pollen\Support\Concerns\BootableTraitInterface;
use Pollen\Support\Concerns\ConfigBagAwareTraitInterface;
use Pollen\Support\Concerns\ResourcesAwareTraitInterface;
use Pollen\Support\Proxy\ContainerProxyInterface;
use Pollen\Support\Proxy\PartialProxyInterface;
use Pollen\ThemeSuite\Adapters\AdapterInterface;

interface ThemeSuiteInterface extends
    BootableTraitInterface,
    ContainerProxyInterface,
    ConfigBagAwareTraitInterface,
    PartialProxyInterface,
    ResourcesAwareTraitInterface
{
    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): ThemeSuiteInterface;

    /**
     * Récupération de l'instance de l'adapteur.
     *
     * @return AdapterInterface|null
     */
    public function getAdapter(): ?AdapterInterface;

    /**
     * Récupération de la liste des pilotes de boîtes de saisie.
     *
     * @return array
     */
    public function getMetaboxDrivers(): array;

    /**
     * Récupération de la liste des pilotes de portions d'affichage.
     *
     * @return array
     */
    public function getPartialDrivers(): array;

    /**
     * Récupération d'un service fourni par le conteneur d'injection de dépendance.
     *
     * @param string $name
     *
     * @return callable|object|string|null
     */
    public function getProvider(string $name);

    /**
     * Définition de l'adapteur associé.
     *
     * @param AdapterInterface $adapter
     *
     * @return static
     */
    public function setAdapter(AdapterInterface $adapter): ThemeSuiteInterface;
}
