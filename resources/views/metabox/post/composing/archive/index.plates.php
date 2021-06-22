<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<?php if ($this->get('banner')) : ?>
    <?php $this->insert('banner', $this->all()); ?>
<?php endif; ?>

<?php if ($this->get('banner_format')) : ?>
    <?php $this->insert('banner_format', $this->all()); ?>
<?php endif; ?>

<?php if ($this->get('excerpt')) : ?>
    <?php $this->insert('excerpt', $this->all()); ?>
<?php endif; ?>