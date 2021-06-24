<?php
/**
 * @var Pollen\Partial\PartialTemplateInterface $this
 * @var Pollen\WpPost\WpPostQuery|null $post
 */
?>
<article <?php echo $this->htmlAttrs(); ?>>
    <?php if ($content = $this->get('content', '')) : ?>
        <div class="ArticleBody-content<?php echo !!$this->get('content-editor') ? ' ArticleBody-content--editor': ''; ?>">
            <?php echo $content; ?>
        </div>
    <?php endif; ?>
</article>