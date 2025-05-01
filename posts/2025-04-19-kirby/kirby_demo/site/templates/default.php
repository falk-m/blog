<h1><?= $page->title() ?></h1>

<?= snippet('nav') ?>

<hr />

<div>
    <?= $page->text() ?>
</div>

<hr />

<?= snippet('dates') ?>

<hr />

<?php echo $site->address() ?>

<hr />
<ul>
    <?php foreach ($site->footernav()->toPages() as $item): ?>
        <li><a href="<?php echo $item->url() ?>"><?php echo $item->title() ?></a></li>
    <?php endforeach ?>
</ul>