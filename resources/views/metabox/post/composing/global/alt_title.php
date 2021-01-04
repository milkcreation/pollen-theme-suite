<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\QueryPost $post
 */
?>
<tr>
    <th><?php _e('Titre alternatif', 'tify'); ?></th>
    <td>
        <?php echo field('text', [
            'attrs' => [
                'class' => 'widefat',
            ],
            'name'  => $this->getName() . '[alt_title]',
            'value' => $post->getGlobalComposing('alt_title'),
        ]); ?>
    </td>
</tr>
