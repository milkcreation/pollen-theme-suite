<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<h3><?php _e('Liste des publications apparentées', 'tify'); ?></h3>
<table class="form-table">
    <tr>
        <th><?php _e('Activation de l\'affichage', 'tify'); ?></th>
        <td>
            <?php echo field('toggle-switch', [
                'name'  => $this->getName() . '[enabled][children]',
                'value' => $post->getSingularComposing('enabled.children') ? 'on' : 'off',
            ]); ?>
        </td>
    </tr>
</table>

