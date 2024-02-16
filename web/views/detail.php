<?php $this->layout('layout/default', ['title' => $post['header']['title'] ?? '']) ?>


<h1 class="c_h1 l-mb-1"><?php echo $post['header']['title'] ?? '' ?></h1>

<div class="l-mb-1">
    <?php echo $post['header']['date'] ?? '-'; ?> <?php echo  $this->format_tags($post['header']['taxonomy']['tag'] ?? []) ?>
</div>


<div class="c-detail-content">
    <?php echo $post['content']; ?>
</div>

<div class="l-mt-2 l-mb-1">
    <a href="<?php echo $baseUrl ?>">&#10096; back</a>
</div>