<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 */
?>
<h3><?php _e('Images', 'tify'); ?></h3>
<div class="ThemeContainer" style="padding:0; overflow:hidden;">
    <?php $i = 0; ?>
    <?php foreach (range(1, $this->get('rows')) as $r) : ?>
        <div class="ThemeRow">
            <?php foreach (range(1, $this->get('by_row')) as $c) : ?>
                <?php if (++$i > $this->get('max')) {
                    continue;
                } ?>
                <div class="ThemeCol-<?php echo $this->get('col'); ?>">
                    <div class="ImageGalleryMetabox-image">
                        <?php if ($mediaImg = $this->get('media-image', [])) : ?>
                            <div class="ImageGalleryMetabox-imagePreview">
                                <?php echo field('media-image', array_merge($mediaImg, [
                                    'name'  => $this->getName() . "[items][{$i}][img]",
                                    'value' => $this->getValue("items.{$i}.img"),
                                ])); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($caption = $this->get('caption', [])) : ?>
                            <div class="ImageGalleryMetabox-imageCaption">
                                <?php echo field('text', array_merge($caption, [
                                    'name'  => $this->getName() . "[items][{$i}][caption]",
                                    'value' => $this->getValue("items.{$i}.caption"),
                                ])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>