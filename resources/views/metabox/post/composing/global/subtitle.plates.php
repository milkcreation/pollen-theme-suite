<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<tr>
    <th><?php _e('Sous-titre', 'tify'); ?></th>
    <td>
        <?php echo field('text', [
            'attrs' => [
                'class' => 'widefat',
            ],
            'name'  => $this->getName() . '[subtitle]',
            'value' => $post->getGlobalComposing('subtitle'),
        ]); ?>
    </td>
</tr>
