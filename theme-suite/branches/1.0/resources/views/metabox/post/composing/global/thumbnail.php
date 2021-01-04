<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\QueryPost $post
 */
?>
<table class="form-table">
    <tr>
        <th><?php _e('Image représentative par défaut', 'tify'); ?></th>
        <td>
            <?php echo field('media-image', [
                'width'      => 1920,
                'height'     => 1080,
                'name'       => '_thumbnail_id',
                'value'      => $post->getMetaSingle('_thumbnail_id'),
                'value_none' => '-1',
            ]); ?>
        </td>
    </tr>
</table>
