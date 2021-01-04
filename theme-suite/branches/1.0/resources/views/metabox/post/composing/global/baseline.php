<?php
/**
 * @var tiFy\Metabox\MetaboxViewInterface$this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\QueryPost $post
 */
?>
<tr>
    <th><?php _e('Slogan (baseline)', 'tify'); ?></th>
    <td>
        <?php echo field('text', [
            'attrs' => [
                'class' => 'widefat',
            ],
            'name'  => $this->getName() . '[baseline]',
            'value' => $post->getGlobalComposing('baseline'),
        ]); ?>
    </td>
</tr>
