<?php declare(strict_types=1);

namespace Pollen\ThemeSuite;

use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Concerns\ResourcesAwareTrait;
use Pollen\Support\Exception\ManagerRuntimeException;
use Pollen\Support\Proxy\ContainerProxy;
use Pollen\Support\Proxy\PartialProxy;
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
use Pollen\Support\Concerns\BootableTrait;
use Psr\Container\ContainerInterface as Container;

class ThemeSuite implements ThemeSuiteInterface
{
    use BootableTrait;
    use ContainerProxy;
    use ConfigBagAwareTrait;
    use PartialProxy;
    use ResourcesAwareTrait;

    /**
     * Instance de la classe.
     */
    private static ?ThemeSuiteInterface $instance = null;

    /**
     * Instance de l'adapteur associé
     */
    private ?AdapterInterface $adapter;

    /**
     * Liste des services par défaut fournis par conteneur d'injection de dépendances.
     */
    private array $defaultProviders = [];

    /**
     * Liste des pilotes de métabox.
     */
    private array $partialDrivers = [
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
     */
    private array $metaboxDrivers = [
        'image-gallery'      => ImageGalleryMetabox::class,
        'archive-composing'  => ArchiveMetabox::class,
        'global-composing'   => GlobalMetabox::class,
        'singular-composing' => SingularMetabox::class,
    ];

    /**
     * @param array $config
     * @param Container|null $container
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
     * Récupération de l'instance principale.
     *
     * @return static
     */
    public static function getInstance():  ThemeSuiteInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new ManagerRuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): ThemeSuiteInterface
    {
        if (!$this->isBooted()) {
            //events()->trigger('theme-suite.booting', [$this]);

            foreach ($this->partialDrivers as $alias => $abstract) {
                if ($this->containerHas($abstract)) {
                    $this->partial()->register($alias, $abstract);
                } elseif (class_exists($abstract)) {
                    $this->partial()->register($alias, new $abstract($this, $this->partial()));
                }
            }

            /* * /
            foreach ($this->metaboxDrivers as $alias => $abstract) {
                if($this->containerHas($abstract)) {
                    $this->metaboxManager()->registerDriver($alias, $abstract);
                } elseif (class_exists($abstract)) {
                    $this->metaboxManager()->registerDriver($alias, new $abstract($this, $this->metaboxManager()));
                }
            }
            /**/

            $this->setBooted();

            //events()->trigger('theme-suite.booted', [$this]);
        }

        return $this;
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
        return $this->config("providers.$name", $this->defaultProviders[$name] ?? null);
    }

    /**
     * @inheritDoc
     */
    public function setAdapter(AdapterInterface $adapter): ThemeSuiteInterface
    {
        $this->adapter = $adapter;

        return $this;
    }
}
