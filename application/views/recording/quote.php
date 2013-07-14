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
		<button class="btn" type="button"><i class="icon-facebook"></i> Share on facebook</button>
		<button class="btn" type="button"><i class="icon-twitter"></i> Share on twitter</button>
		<button class="btn"type="button"><i class="icon-envelope"></i> Share by email</button>
		<a href="#phone-share-widget" role="button" class="btn" data-toggle="modal">
			<i class="icon-phone"></i>  Share by phone
		</a>
	</div>
</div>

<div id="phone-share-widget" class="modal hide fade" role="dialog" tabindex="-1">
	<form id="phone-share-form" class="form-horizontal" action="/calls/scheduleshare" method="post">
		<input type="hidden" name="quote_id" value="<?=$quote->id;?>"</input>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel"><i class="icon-phone"></i>Share by phone</h3>
		</div>
		<div class="modal-body">
			<p>We can phone the number you provide and play them this quote. Don't be evil.</p>
			<div class="control-group">
				<label class="control-label">Number to call:</label>
				<div class="controls">
					<input type="text" name="dest_number" value="">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">When should we call?</label>
				<div class="controls">
					<label class="radio">
						<input type="radio" name="call_when" id="optionsRadios1" value="now" checked>
						Now
					</label>
					<label class="radio">
						<input type="radio" name="call_when" id="optionsRadios1" value="future">
						In the future:
					</label>
					<div class="input-append">
						<input class="span2" id="appendedInputButton" name="call_at" type="text" disabled>
						<button class="btn" type="button" disabled><i class="icon-calendar"></i></button>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">What is your number?</label>
				<div class="controls">
					<input type="text" name="sender_number">
					<span class="help-block">
						We will phone you before scheduling the call so you can record a personal greeting. And we'll
						keep your number in case you ignore where we said don't be evil.
					</span>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
			<button id="schedule-call" class="btn btn-primary" type="submit">Schedule call</button>
		</div>
	</form>
</div>
