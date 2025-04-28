<?php if ($image = $block->image()->toFile()): ?>
    <?php $linkObject = $block->imagelink()->toObject() ?>

    <div class="content-block image">
        <?php if ($linkObject->link()->isNotEmpty()): ?>
            <a
                href="<?= $linkObject->link()->toUrl() ?>"
                <?= $linkObject->target()->toBool() === true ? 'target="_blank"' : '' ?>>
            <?php endif ?>

            <img
                src="<?= $image->resize(1000)->url() ?>"
                srcset="<?= $image->srcset() ?>"
                alt="<?= $image->alt() ?>"
                title="<?= $image->title() ?>"
                sizes="100vw">

            <?php if ($linkObject): ?>
            </a>
        <?php endif ?>

    </div>
<?php endif ?>