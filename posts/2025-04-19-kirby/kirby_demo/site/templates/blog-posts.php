<h1><?= $page->title() ?></h1>

<?= snippet('nav') ?>

<hr />

<ul>
    <?php foreach ($page->children() as $subpage): ?>
        <li>
            <a href="<?= $subpage->url() ?>">
                <?= html($subpage->title()) ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>

Leipzig: <?= $temperature ?>