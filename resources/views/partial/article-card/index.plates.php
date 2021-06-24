<?php
/**
 * @var Pollen\Partial\PartialTemplateInterface $this
 * @var Pollen\WpPost\WpPostQuery $post
 */
?>
<article <?php echo $this->htmlAttrs(); ?>>
    <header class="ArticleCardHeader">
        <a href="<?php echo $post->getPermalink(); ?>"
           title="<?php printf($this->get('readmore.title', __('Consulter %s', 'tify')), $post->getTitle()); ?>">
            <?php if ($this->get('enabled.thumb')) : ?>
                <figure class="ArticleCard-thumb">
                    <?php echo $this->get('thumbnail'); ?>
                </figure>
            <?php endif; ?>

            <?php if ($this->get('enabled.title')) : ?>
                <h3 class="ArticleCard-title"><?php echo $post->getTitle(); ?></h3>
            <?php endif; ?>
        </a>
    </header>

    <main class="ArticleCardBody">
        <?php if ($this->get('enabled.excerpt')) : ?>
            <div class="ArticleCard-excerpt"><?php echo $post->getExcerpt(); ?></div>
        <?php endif; ?>
    </main>

    <footer class="ArticleCardFooter">
        <?php if ($this->get('enabled.readmore') && ($this->get('readmore') !== false)) : ?>
            <div class="ArticleCard-readmore">
                <?php echo $this->get('readmore'); ?>
            </div>
        <?php endif; ?>
    </footer>
</article>