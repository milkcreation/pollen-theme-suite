<?php declare(strict_types=1);

namespace Pollen\ThemeSuite;

use tiFy\Container\ServiceProvider;
use tiFy\Contracts\Metabox\MetaboxDriver;
use Pollen\ThemeSuite\Contracts\ThemeSuiteContract;
use Pollen\ThemeSuite\Adapters\WordpressAdapter;
use Pollen\ThemeSuite\Metabox\ImageGalleryMetabox;
use Pollen\ThemeSuite\Metabox\Post\Composing\ArchiveMetabox;
use Pollen\ThemeSuite\Metabox\Post\Composing\GlobalMetabox;
use Pollen\ThemeSuite\Metabox\Post\Composing\SingularMetabox;
use Pollen\ThemeSuite\Partial\ArticleBodyPartial;
use Pollen\ThemeSuite\Partial\ArticleCardPartial;
use Pollen\ThemeSuite\Partial\ArticleChildrenPartial;
use Pollen\ThemeSuite\Partial\ArticleFooterPartial;
use Pollen\ThemeSuite\Partial\ArticleHeaderPartial;
use Pollen\ThemeSuite\Partial\ArticleTitlePartial;
use Pollen\ThemeSuite\Partial\NavMenuPartial;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Wordpress\Query\QueryPost as post;
use WP_Post;

class ThemeSuiteServiceProvider extends ServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        ThemeSuiteContract::class,
        ArticleBodyPartial::class,
        ArticleCardPartial::class,
        ArticleChildrenPartial::class,
        ArticleFooterPartial::class,
        ArticleHeaderPartial::class,
        ArticleTitlePartial::class,
        ArchiveMetabox::class,
        ArticleBodyPartial::class,
        ArticleCardPartial::class,
        ArticleChildrenPartial::class,
        ArticleFooterPartial::class,
        ArticleHeaderPartial::class,
        ArticleTitlePartial::class,
        GlobalMetabox::class,
        ImageGalleryMetabox::class,
        NavMenuPartial::class,
        SingularMetabox::class,
        WordpressAdapter::class
    ];

    /**
     * @inheritDoc
     */
    public function boot()
    {
        events()->listen('wp.booted', function () {
            /** @var ThemeSuiteContract $themeSuite */
            $themeSuite = $this->getContainer()->get(ThemeSuiteContract::class);
            $themeSuite->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
        });
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->getContainer()->share(ThemeSuiteContract::class, function (): ThemeSuiteContract {
            return new ThemeSuite(config('theme-suite', []), $this->getContainer());
        });

        $this->registerAdapters();
        $this->registerPartialDrivers();
        $this->registerMetaboxDrivers();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(WordpressAdapter::class, function () {
            return new WordpressAdapter($this->getContainer()->get(ThemeSuiteContract::class));
        });
    }

    /**
     * Déclaration de la collection de pilotes de portions d'affichage.
     *
     * @return void
     */
    public function registerPartialDrivers(): void
    {
        $this->getContainer()->add(ArticleBodyPartial::class, function () {
            return new ArticleBodyPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(ArticleCardPartial::class, function () {
            return new ArticleCardPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(ArticleChildrenPartial::class, function () {
            return new ArticleChildrenPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(ArticleFooterPartial::class, function () {
            return new ArticleFooterPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(ArticleHeaderPartial::class, function () {
            return new ArticleHeaderPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(ArticleTitlePartial::class, function () {
            return new ArticleTitlePartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });

        $this->getContainer()->add(NavMenuPartial::class, function () {
            return new NavMenuPartial(
                $this->getContainer()->get(ThemeSuiteContract::class),
                $this->getContainer()->get(PartialContract::class)
            );
        });
    }

    /**
     * Déclaration de la collection de pilote de metaboxes.
     *
     * @return void
     */
    public function registerMetaboxDrivers(): void
    {
        $this->getContainer()->share(ImageGalleryMetabox::class, function () {
            return (new ImageGalleryMetabox())->setThemeSuite($this->getContainer()->get(ThemeSuiteContract::class));
        });

        $this->getContainer()->share(ArchiveMetabox::class, function () {
            return (new ArchiveMetabox())
                ->setThemeSuite($this->getContainer()->get(ThemeSuiteContract::class))
                ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                    $box->set('post', post::create($wp_post));
                });
        });

        $this->getContainer()->share(GlobalMetabox::class, function () {
            return (new GlobalMetabox())
                ->setThemeSuite($this->getContainer()->get(ThemeSuiteContract::class))
                ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                    $box->set('post', post::create($wp_post));
                });
        });

        $this->getContainer()->share(SingularMetabox::class, function () {
            return (new SingularMetabox())
                ->setThemeSuite($this->getContainer()->get(ThemeSuiteContract::class))
                ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                    $box->set('post', post::create($wp_post));
                });
        });
    }
}
