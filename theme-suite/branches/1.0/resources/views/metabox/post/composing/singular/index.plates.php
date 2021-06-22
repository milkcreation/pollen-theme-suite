<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<?php if ($this->get('header')) : ?>
    <?php $this->insert('header', $this->all()); ?>
<?php endif; ?>

<?php if ($this->get('children') && $post->getType()->hierarchical) : ?>
    <?php $this->insert('children', $this->all()); ?>

    <?php if ($this->get('children_title')) : ?>
        <?php $this->insert('children_title', $this->all()); ?>
    <?php endif; ?>
<?php endif;