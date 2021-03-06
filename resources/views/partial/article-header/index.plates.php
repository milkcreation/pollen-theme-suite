<?php
/**
 * @var Pollen\Partial\PartialTemplateInterface $this
 * @var Pollen\WpPost\WpPostQuery|null $post
 */
?>
<?php if ($this->get('enabled', false)) : ?>
    <div <?php echo $this->htmlAttrs(); ?>>
        <?php if ($this->get('content') !== false) : ?>
            <?php $this->insert('content', $this->all()); ?>

            <?php if ($this->get('title') !== false) : ?>
                <?php $this->insert('title', $this->all()); ?>
            <?php endif; ?>

            <?php if ($this->get('breadcrumb') !== false) : ?>
                <?php $this->insert('breadcrumb', $this->all()); ?>
            <?php endif; ?>
        <?php else : ?>
            <?php if ($this->get('breadcrumb') !== false) : ?>
                <?php $this->insert('breadcrumb', $this->all()); ?>
            <?php endif; ?>

            <?php if ($this->get('title') !== false) : ?>
                <?php $this->insert('title', $this->all()); ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif;