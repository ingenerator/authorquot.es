<?php
/**
 * List of categories with their quotes
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Quote[][] $category_quotes array of 6 random quotes for each category
 * @var array 			$category_names array of the category names
 */
?>
<div class="container">
<?php foreach ($category_quotes as $key => $quotes): ?>
	<div class="span3 category_sample">
		<h4 style="border-bottom: 1px solid #ccc;">
			<a href="/category/<?=$key;?>"><?=$category_names[$key];?></a> quotes
		</h4>
		<ul class="thumbnails">
			<?php foreach ($quotes as $quote):
				$title = htmlspecialchars($quote->speakers.' : '.$quote->description);
				?>
				<li class="span1">
					<a href="/recording/<?=$quote->recording_id;?>/quote/<?=$quote->id;?>"
					   title="<?=$title?>"
					>
						<img src="<?=$quote->Recording->thumb_url;?>"
							 alt="<?=$title;?>"
							 title="><?=$title;?>"
						>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<p><a href="/category/<?=$key;?>">View all &gt;</a></p>
	</div>
<?php endforeach; ?>
</div>
