<?php
/**
 * @var Pollen\Partial\PartialTemplateInterface $this
 * @var Pollen\WpPost\WpPostQuery|null $post
 */
?>
<?php if ($this->get('enabled', false)) : ?>
    <div <?php echo $this->htmlAttrs(); ?>>
        <?php if ($this->get('content') !== false) : ?>
            <div class="ArticleFooter-content">
                <?php echo $this->get('content'); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif;