<?php
/**
 * List of quote categories with a sample of quotes for each
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Quote[] $quotes        the quotes in this category
 * @var string        $category_name the category name
 *
 */
?>
<div class="container">
	<h2>Browse <?=$category_name;?> quotes
		<small>Or <a href="/categories">view all categories</a></small>
	</h2>

	<ul class="media-list">
		<?php foreach ($quotes as $quote):
			$quote_url = '/recording/'.$quote->recording_id.'/quote/'.$quote->id.'?play=1';
			?>
			<li class="media">
				<a class="pull-left text-center" href="<?=$quote_url;?>">
					<img style="width:50px;" class="media-object" src="<?=htmlspecialchars($quote->Recording->thumb_url);?>">
				</a>
				<div class="media-body">
					<h4 class="media-heading">
							<?=htmlspecialchars($quote->speakers);?> : <?=htmlspecialchars($quote->description);?>
					</h4>
					<a href="<?=$quote_url;?>">
						<i class="icon-play"></i>
						Play and share
					</a>
				</div>
			</li>

		<?php endforeach; ?>
	</ul>
</div>

