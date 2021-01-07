<?php
/**
 * @var tiFy\Partial\PartialViewInterface $this
 * @var tiFy\Wordpress\Contracts\Query\QueryPost|null $post
 */
?>
<div class="ArticleHeader-breadcrumb">
    <?php echo partial('breadcrumb', $this->get('breadcrumb')); ?>
</div>
