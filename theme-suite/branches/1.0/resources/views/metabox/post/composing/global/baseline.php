<?php
/**
 * @var tiFy\Contracts\Metabox\MetaboxView $this
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
            'name'  => $this->name() . '[baseline]',
            'value' => $post->getGlobalComposing('baseline'),
        ]); ?>
    </td>
</tr>
