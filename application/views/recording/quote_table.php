<?php
/**
 * View the details of a quote as a child of a recording page
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Recording $recording the recording model
 * @var Model_Quote[]   $quotes    the quote model
 * @var boolean			$row_only  only render a the rows, not the data (for inserting into an existing table)
 */

if ( ! isset($row_only)) {
	$row_only = FALSE;
}
?>
<?php if ( ! $row_only): ?>
<h4>Quotes in this recording</h4>
<table class="table table-condensed" id="quotes-table">
	<thead>
		<th>Description</th>
		<th>Speaking</th>
		<th>Length</th>
		<th>Tags</th>
		<th></th>
	</thead>
	<tbody>
<?php endif; ?>

<?php foreach ($quotes as $quote):
	$duration = new DateTime();
	$duration->setTimestamp($quote->end - $quote->start);
	$duration->setTimezone(new DateTimeZone('UTC'));
	?>
	<tr>
		<td><?=htmlspecialchars($quote->description); ?></td>
		<td><?=htmlspecialchars($quote->speakers); ?></td>
		<td><?=$duration->format('H:i:s');?></td>
		<td>
			<?php if ($quote->provocative): ?>
				<span class="label">
					provocative
				</span>
			<?php endif; ?>
			<?php if ($quote->inspiring): ?>
				<span class="label">
					inspiring
				</span>
			<?php endif; ?>
			<?php if ($quote->meaningful): ?>
				<span class="label">
					meaningful
				</span>
			<?php endif; ?>
			<?php if ($quote->amusing): ?>
				<span class="label">
					amusing
				</span>
			<?php endif; ?>
			<?php if ($quote->intriguing): ?>
				<span class="label">
					intriguing
				</span>
			<?php endif; ?>
		</td>
		<td>
			<button class="btn" data-play-quote="<?=$quote->id;?>">
				<i class="icon-play"></i> Play
			</button>
			<button class="btn" data-share-quote="<?=$quote->id;?>">
				<i class="icon-share-alt"></i> Share
			</button>
		</td>
	</tr>
<?php endforeach; ?>

<?php if ( ! $row_only): ?>
	</tbody>
</table>
<?php endif; ?>
