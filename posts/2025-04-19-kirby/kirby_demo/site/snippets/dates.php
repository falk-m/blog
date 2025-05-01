<?php $dates = pages('dates')->children()
    ->listed()
    ->filter(function ($child) use ($page) {
        return $child->date_from()->toDate() >= (time() - (60 * 60 * 12));
    })
    ->sortBy('date_from', 'asc')
    ->paginate(4);
?>

<ul>
    <?php foreach ($dates as $dateItem): ?>

        <li>
            <span class="date-date"><?php echo $dateItem->date_from()->toDate('d.m.Y') ?></span>
            <span class="date-title"><?php echo $dateItem->title() ?></span>
        </li>

    <?php endforeach ?>
</ul>