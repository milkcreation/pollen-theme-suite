<?php
/**
 * @var Pollen\Partial\PartialTemplateInterface $this
 * @var Pollen\WpPost\WpPostQuery|null $post
 */
?>
<div class="ArticleHeader-title">
    <?php echo partial('article-title', $this->get('title')); ?>
</div>
