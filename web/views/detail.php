<?php $this->layout('layout/default', ['title' => $post['header']['title'] ?? '']) ?>


<h1 class="c_h1 l-mb-1"><?php echo $post['header']['title'] ?? '' ?></h1>


<div class="c-detail-content">
    <?php echo $post['content']; ?>
</div>