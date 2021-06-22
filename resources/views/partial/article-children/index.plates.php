<?php
/**
 * @var Pollen\Partial\PartialTemplate $this
 * @var Pollen\WpPost\WpPostQuery $post
 */
?>
<div <?php echo $this->htmlAttrs(); ?>>
    <?php if ($title = $this->get('title')) : ?>
        <h2 class="ArticleChildren-title"><?php echo $title; ?></h2>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($this->get('children') as $child) : ?>
            <div class="col-4">
                <?php echo partial('article-card', ['post' => $child]); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>