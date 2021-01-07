<?php
/**
 * @var tiFy\Partial\PartialViewInterface $this
 * @var tiFy\Wordpress\Contracts\Query\QueryPost|null $post
 */
?>
<<?php echo $this->get('tag', 'h1'); ?> <?php echo $this->htmlAttrs(); ?>>
    <?php if ($before = $this->get('before')) : ?>
        <span class="ArticleTitle-before"><?php echo $before; ?></span>
    <?php endif; ?>
    <?php if ($content = $this->get('content')) : ?>
        <span class="ArticleTitle-content"><?php echo $content; ?></span>
    <?php endif; ?>
    <?php if ($after = $this->get('after')) : ?>
        <span class="ArticleTitle-after"><?php echo $after; ?></span>
    <?php endif; ?>
</<?php echo $this->get('tag', 'h1'); ?>>