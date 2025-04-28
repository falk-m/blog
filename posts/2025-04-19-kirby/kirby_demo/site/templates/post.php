<h1><?= $page->title() ?></h1>

<?= $page->date()->toDate('d.m.Y') ?>

<hr />

<?php foreach ($page->text()->toBlocks() as $block): ?>
    <?php snippet('blocks/' . $block->type(), [
        'block' => $block
    ]) ?>
<?php endforeach ?>

<h2>Tags</h2>

<ul>
    <?php foreach ($page->tags()->split() as $category): ?>
        <li><?= $category ?></li>
    <?php endforeach ?>
</ul>