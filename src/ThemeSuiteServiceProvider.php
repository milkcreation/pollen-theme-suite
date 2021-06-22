<?php

declare(strict_types=1);

namespace Pollen\ThemeSuite;

use Pollen\Container\BootableServiceProvider;
use Pollen\Partial\PartialManagerInterface;
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

class ThemeSuiteServiceProvider extends BootableServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
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
        ThemeSuiteInterface::class,
        WordpressAdapter::class,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var ThemeSuiteInterface $themeSuite */
        if (defined('WPINC')) {
            $themeSuite = $this->getContainer()->get(ThemeSuiteInterface::class);
            $themeSuite->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
        }
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(
            ThemeSuiteInterface::class,
            function (): ThemeSuiteInterface {
                return new ThemeSuite([], $this->getContainer());
            }
        );

        $this->registerAdapters();
        $this->registerPartialDrivers();
        //$this->registerMetaboxDrivers();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(
            WordpressAdapter::class,
            function () {
                return new WordpressAdapter($this->getContainer()->get(ThemeSuiteInterface::class));
            }
        );
    }

    /**
     * Déclaration de la collection de pilotes de portions d'affichage.
     *
     * @return void
     */
    public function registerPartialDrivers(): void
    {
        $this->getContainer()->add(
            ArticleBodyPartial::class,
            function () {
                return new ArticleBodyPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );

        $this->getContainer()->add(
            ArticleCardPartial::class,
            function () {
                return new ArticleCardPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
        $this->getContainer()->add(
            ArticleChildrenPartial::class,
            function () {
                return new ArticleChildrenPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
        $this->getContainer()->add(
            ArticleFooterPartial::class,
            function () {
                return new ArticleFooterPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
        $this->getContainer()->add(
            ArticleHeaderPartial::class,
            function () {
                return new ArticleHeaderPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
        $this->getContainer()->add(
            ArticleTitlePartial::class,
            function () {
                return new ArticleTitlePartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
        $this->getContainer()->add(
            NavMenuPartial::class,
            function () {
                return new NavMenuPartial(
                    $this->getContainer()->get(ThemeSuiteInterface::class),
                    $this->getContainer()->get(PartialManagerInterface::class)
                );
            }
        );
    }

    /**
     * Déclaration de la collection de pilote de metaboxes.
     *
     * @return void
     * /
    public function registerMetaboxDrivers(): void
    {
        $this->getContainer()->share(
            ImageGalleryMetabox::class,
            function () {
                return new ImageGalleryMetabox(
                    $this->getContainer()->get(ThemeSuiteContract::class),
                    $this->getContainer()->get(MetaboxContract::class)
                );
            }
        );

        $this->getContainer()->share(
            ArchiveMetabox::class,
            function () {
                return (new ArchiveMetabox(
                    $this->getContainer()->get(ThemeSuiteContract::class),
                    $this->getContainer()->get(MetaboxContract::class)
                ))
                    ->setHandler(
                        function (MetaboxDriverInterface $box, WP_Post $wp_post) {
                            $box->set('post', post::create($wp_post));
                        }
                    );
            }
        );

        $this->getContainer()->share(
            GlobalMetabox::class,
            function () {
                return (new GlobalMetabox(
                    $this->getContainer()->get(ThemeSuiteContract::class),
                    $this->getContainer()->get(MetaboxContract::class)
                ))
                    ->setHandler(
                        function (MetaboxDriverInterface $box, WP_Post $wp_post) {
                            $box->set('post', post::create($wp_post));
                        }
                    );
            }
        );

        $this->getContainer()->share(
            SingularMetabox::class,
            function () {
                return (new SingularMetabox(
                    $this->getContainer()->get(ThemeSuiteContract::class),
                    $this->getContainer()->get(MetaboxContract::class)
                ))
                    ->setHandler(
                        function (MetaboxDriverInterface $box, WP_Post $wp_post) {
                            $box->set('post', post::create($wp_post));
                        }
                    );
            }
        );
    }
    /**/
}
