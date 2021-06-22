<?php
/**
 * @var Pollen\Metabox\MetaboxTemplate $this
 * @var WP_Post $wp_post
 * @var Pollen\ThemeSuite\Query\WpPostQuery $post
 */
?>
<table class="form-table">
    <tr>
        <th>
            <?php _e('Extrait', 'tify'); ?>
        </th>
        <td>
            <?php echo field('text-remaining', [
                'name'  => 'excerpt',
                'value' => nl2br($post->get('post_excerpt', '')),
            ]); ?>
        </td>
    </tr>
</table>
