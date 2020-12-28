<?php declare(strict_types=1);

namespace Pollen\ThemeSuite;

use RuntimeException;
use Psr\Container\ContainerInterface as Container;
use Pollen\ThemeSuite\Adapters\AdapterInterface;
use Pollen\ThemeSuite\Metabox\Post\Composing\ArchiveMetabox;
use Pollen\ThemeSuite\Metabox\Post\Composing\GlobalMetabox;
use Pollen\ThemeSuite\Metabox\Post\Composing\SingularMetabox;
use Pollen\ThemeSuite\Metabox\ImageGalleryMetabox;
use Pollen\ThemeSuite\Partial\ArticleBodyPartial;
use Pollen\ThemeSuite\Partial\ArticleCardPartial;
use Pollen\ThemeSuite\Partial\ArticleChildrenPartial;
use Pollen\ThemeSuite\Partial\ArticleFooterPartial;
use Pollen\ThemeSuite\Partial\ArticleHeaderPartial;
use Pollen\ThemeSuite\Partial\ArticleTitlePartial;
use Pollen\ThemeSuite\Partial\NavMenuPartial;
use Pollen\ThemeSuite\Contracts\ThemeSuiteContract;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Partial\Partial;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class ThemeSuite implements ThemeSuiteContract
{
    use BootableTrait;
    use ContainerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Instance de l'adapteur associé
     * @var AdapterInterface|null
     */
    private $adapter;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    private $configBag;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     * @var array
     */
    private $defaultProviders = [];

    /**
     * Liste des pilotes de métabox.
     * @var array
     */
    private $partialDrivers = [
        'article-body'     => ArticleBodyPartial::class,
        'article-card'     => ArticleCardPartial::class,
        'article-children' => ArticleChildrenPartial::class,
        'article-header'   => ArticleHeaderPartial::class,
        'article-footer'   => ArticleFooterPartial::class,
        'article-title'    => ArticleTitlePartial::class,
        'nav-menu'         => NavMenuPartial::class,
    ];

    /**
     * Liste des pilotes de métabox.
     * @var array
     */
    private $metaboxDrivers = [
        'image-gallery'      => ImageGalleryMetabox::class,
        'archive-composing'  => ArchiveMetabox::class,
        'global-composing'   => GlobalMetabox::class,
        'singular-composing' => SingularMetabox::class,
    ];

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

    /**
     * Instance du gestion de portions d'affichage.
     * @var PartialContract
     */
    protected $partialManager;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): ThemeSuiteContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): ThemeSuiteContract
    {
        if (!$this->isBooted()) {
            events()->trigger('theme-suite.booting', [$this]);

            foreach ($this->partialDrivers as $alias => $abstract) {
                if($this->containerHas($abstract)) {
                    $this->partialManager()->register($alias, $abstract);
                } elseif (class_exists($abstract)) {
                    $this->partialManager()->register($alias, new $abstract($this, $this->partialManager()));
                }
            }

            $this->setBooted();

            events()->trigger('theme-suite.booted', [$this]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->configBag) || is_null($this->configBag)) {
            $this->configBag = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->configBag->get($key, $default);
        } elseif (is_array($key)) {
            return $this->configBag->set($key);
        } else {
            return $this->configBag;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAdapter(): ?AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @inheritDoc
     */
    public function getMetaboxDrivers() : array
    {
        return $this->metaboxDrivers;
    }

    /**
     * @inheritDoc
     */
    public function getPartialDrivers() : array
    {
        return $this->partialDrivers;
    }

    /**
     * @inheritDoc
     */
    public function getProvider(string $name)
    {
        return $this->config("providers.{$name}", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function partialManager(): PartialContract
    {
        if ($this->partialManager === null) {
            $this->partialManager = $this->containerHas(PartialContract::class)
                ? $this->containerGet(PartialContract::class) : new Partial();
        }

        return $this->partialManager;
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) || is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
        }

        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setAdapter(AdapterInterface $adapter): ThemeSuiteContract
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): ThemeSuiteContract
    {
        $this->config($attrs);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPartialManager(PartialContract $partialManager): ThemeSuiteContract
    {
        $this->partialManager = $partialManager;

        return $this;
    }
}
