<?php declare(strict_types=1);

namespace Pollen\ThemeSuite;

use RuntimeException;
use Psr\Container\ContainerInterface as Container;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Contracts\Partial\Partial as PartialManagerContract;
use Pollen\ThemeSuite\Adapters\ThemeSuiteAdapterInterface;
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
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Metabox;
use tiFy\Support\Proxy\Storage;

class ThemeSuite implements ThemeSuiteContract
{
    use BootableTrait, ContainerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

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
     * Instance de l'adapteur associé
     * @var ThemeSuiteAdapterInterface|null
     */
    protected $adapter;

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
            events()->trigger('theme-suite.boot');

            foreach ($this->partialDrivers as $alias => $abstract) {
                if ($this->containerHas($abstract)) {
                    /** @var PartialManagerContract $partialManager */
                    $partialManager = $this->getContainer()->get(PartialManagerContract::class);
                    $partialManager->register($alias, $abstract);
                }
            }

            add_action('after_setup_theme', function () {
                foreach ($this->metaboxDrivers as $alias => $abstract) {
                    if ($this->getContainer()->has($abstract)) {
                        Metabox::registerDriver($alias, $this->getContainer()->get($abstract));
                    }
                }
            });

            $this->setBooted();

            events()->trigger('theme-suite.booted');
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->config) || is_null($this->config)) {
            $this->config = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->config->get($key, $default);
        } elseif (is_array($key)) {
            return $this->config->set($key);
        } else {
            return $this->config;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAdapter(): ?ThemeSuiteAdapterInterface
    {
        return $this->adapter;
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
    public function setAdapter(ThemeSuiteAdapterInterface $adapter): ThemeSuiteContract
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
}
