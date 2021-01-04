<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\QueryPost $post
 */
?>
<?php if ($this->get('baseline') || $this->get('alt_title') || $this->get('subtitle')) : ?>
    <h3><?php _e('Titres', 'tify'); ?></h3>

    <table class="form-table">
        <?php if ($this->get('baseline')) : ?>
            <?php $this->insert('baseline', $this->all()); ?>
        <?php endif; ?>

        <?php if ($this->get('alt_title')) : ?>
            <?php $this->insert('alt_title', $this->all()); ?>
        <?php endif; ?>

        <?php if ($this->get('subtitle')) : ?>
            <?php $this->insert('subtitle', $this->all()); ?>
        <?php endif; ?>
    </table>
<?php endif; ?>


<?php if ($this->get('thumbnail') && $post->getType()->supports('thumbnail')) : ?>
    <?php $this->insert('thumbnail', $this->all()); ?>
<?php endif; ?>
