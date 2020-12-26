<?php declare(strict_types=1);

namespace Pollen\ThemeSuite\Contracts;

use Psr\Container\ContainerInterface as Container;
use Pollen\ThemeSuite\Adapters\ThemeSuiteAdapterInterface;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Contracts\Support\ParamsBag;

/**
 * @mixin \tiFy\Support\Concerns\BootableTrait
 * @mixin \tiFy\Support\Concerns\ContainerAwareTrait
 */
interface ThemeSuiteContract
{
    /**
     * Récupération de l'instance.
     *
     * @return static
     */
    public static function instance(): ThemeSuiteContract;

    /**
     * Chargement.
     *
     * @return static
     */
    public function boot(): ThemeSuiteContract;

    /**
     * Récupération de paramètre|Définition de paramètres|Instance du gestionnaire de paramètre.
     *
     * @param string|array|null $key Clé d'indice du paramètre à récupérer|Liste des paramètre à définir.
     * @param mixed $default Valeur de retour par défaut lorsque la clé d'indice est une chaine de caractère.
     *
     * @return ParamsBag|int|string|array|object
     */
    public function config($key = null, $default = null);

    /**
     * Récupération de l'instance de l'adapteur.
     *
     * @return ThemeSuiteAdapterInterface|null
     */
    public function getAdapter(): ?ThemeSuiteAdapterInterface;

    /**
     * Récupération de l'instance du gestionnaire d'injection de dépendances.
     *
     * @return Container|null
     */
    public function getContainer(): ?Container;

    /**
     * Récupération d'un service fourni par le conteneur d'injection de dépendance.
     *
     * @param string $name
     *
     * @return callable|object|string|null
     */
    public function getProvider(string $name);

    /**
     * Chemin absolu vers une ressources (fichier|répertoire).
     *
     * @param string|null $path Chemin relatif vers la ressource.
     *
     * @return LocalFilesystem|string|null
     */
    public function resources(?string $path = null);

    /**
     * Définition de l'adapteur associé.
     *
     * @param ThemeSuiteAdapterInterface $adapter
     *
     * @return static
     */
    public function setAdapter(ThemeSuiteAdapterInterface $adapter): ThemeSuiteContract;

    /**
     * Définition des paramètres de configuration.
     *
     * @param array $attrs Liste des attributs de configuration.
     *
     * @return static
     */
    public function setConfig(array $attrs): ThemeSuiteContract;
}
