<h1><?= $page->title() ?></h1>

<?= snippet('nav') ?>

<hr />

<div>
    <?= $page->text() ?>
</div>

<hr />

<?php echo $site->address() ?>