<?php
/**
 * @var tiFy\Partial\PartialViewInterface $this
 * @var tiFy\Wordpress\Contracts\Query\QueryPost|null $post
 */
?>
<div class="ArticleHeader-title">
    <?php echo partial('article-title', $this->get('title')); ?>
</div>
