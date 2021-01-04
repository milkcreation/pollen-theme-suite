<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 */
?>
<div <?php echo $this->htmlAttrs(); ?>>
    <div class="ImageGalleryMetabox-images">
        <?php $this->insert('images', $this->all()); ?>
    </div>
</div>