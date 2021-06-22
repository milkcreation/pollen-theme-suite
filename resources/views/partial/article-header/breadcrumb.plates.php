<?php
/**
 * @var Pollen\Partial\PartialTemplate $this
 * @var Pollen\WpPost\WpPostQuery|null $post
 */
?>
<div class="ArticleHeader-breadcrumb">
    <?php echo partial('breadcrumb', $this->get('breadcrumb')); ?>
</div>
