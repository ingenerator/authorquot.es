<?php
/**
 * Render list of all recordings
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Recording[] $recordings
 */
?>
<ul class="media-list">
	<?php foreach ($recordings as $recording): ?>
		<li class="media">
			<a class="pull-left text-center" href="/recording/<?=$recording->id?>">
				<img style="width:111px;" class="media-object" src="<?=htmlspecialchars($recording->thumb_url);?>">
				<i class="icon-play"></i> Play
			</a>
			<div class="media-body">
				<h4 class="media-heading"><a href="/recording/<?=$recording->id?>"><?=htmlspecialchars($recording->title);?></a>
					<?php if($quote_count = $recording->Quotes->count_all()): ?>
						<span class="label"><?=$quote_count?> quotes</span>
					<?php endif; ?>
				</h4>
				<?=$recording->description_full;?>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
