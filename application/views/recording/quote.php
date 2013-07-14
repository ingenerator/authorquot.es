<?php
/**
 * Render a player for a single quote
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Quote $quote     the quote to render
 * @var boolean     $auto_play whether to autoplay
 */

?>
<div class="container">
	<div class="media">
		<a class="pull-left">
			<img class="media-object" src="<?=htmlspecialchars($quote->Recording->thumb_url);?>">
		</a>
		<div class="media-body">
			<h2 class="media-heading">Quote from <?=htmlspecialchars($quote->Recording->title);?></h2>
			<dl class="dl-horizontal">
				<dt>Tags:</dt>
				<dd>
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
				</dd>
				<dt>Speaker(s):</dt>
				<dd><?=htmlspecialchars($quote->speakers);?></dd>
				<dt>Description:</dt>
				<dd><?=htmlspecialchars($quote->description);?></dd>
			</dl>
		</div>
</div>

<div class="row pad-below">
	<div class="span9">
		<div id='audio-player'>
			<img src="/assets/img/spinner.gif" height="28px">
		</div>
		<script type="text/javascript">
			jwplayer('audio-player').setup({
				file: <?=json_encode($quote->clip_url);?>,
				width: '100%',
				height: '28',
				autostart: <?=json_encode($auto_play);?>
			});
		</script>
	</div>
	<div class="span3">
		<a href="/recording/<?=$quote->Recording->id;?>" class="btn">
			Find more quotes in the full recording
		</a>
	</div>
</div>

<div class="row">
	<div class="span12">
		<button type="button"><i class="icon-facebook"></i> Share on facebook</button>
		<button type="button"><i class="icon-twitter"></i> Share on twitter</button>
		<button type="button"><i class="icon-envelope"></i> Share by email</button>
		<button type="button"><i class="icon-phone"></i> Share by phone</button>
	</div>
</div>
