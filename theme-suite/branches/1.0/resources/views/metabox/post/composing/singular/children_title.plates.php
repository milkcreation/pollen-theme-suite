<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<table class="form-table">
    <tr>
        <th><?php _e('Titre haut', 'tify'); ?></th>
        <td>
            <?php echo field('text', [
                'attrs' => [
                    'class' => 'widefat',
                ],
                'name'  => $this->getName() . '[children_title]',
                'value' => $post->getSingularComposing('children_title'),
            ]); ?>
        </td>
    </tr>
</table>
