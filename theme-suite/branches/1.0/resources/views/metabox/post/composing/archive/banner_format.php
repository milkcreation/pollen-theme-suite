<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\QueryPost $post
 */
?>
<table class="form-table">
    <tr>
        <th>
            <?php _e('Ajuster l\'image', 'tify'); ?>

        </th>
        <td>
            <?php echo field('toggle-switch', [
                'attrs' => [
                    'id'          => 'ArchiveBannerAdjust-switcher',
                    'data-target' => '#ArchiveBannerAdjust-img',
                ],
                'name'  => $this->getName() . '[enabled][banner_format]',
                'value' => $post->getArchiveComposing('enabled.banner_format') ? 'on' : 'off',
            ]); ?>
        </td>
    </tr>
</table>
