<div class="content-block headline">

	<h2>
		<?= $block->text() ?>
	</h2>

	<?php if ($block->subheadline()->isNotEmpty()): ?>
		<h3>
			<?= $block->subheadline() ?>
		</h3>
	<?php endif ?>

</div>