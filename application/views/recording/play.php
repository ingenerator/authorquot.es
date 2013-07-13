<?php
/**
 * View the details and player of a single recording together with the main player and clip editor
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var array $recording the recording data
 */
?>
<div class="container">
	<div class="media">
		<a class="pull-left">
			<img class="media-object" src="<?=htmlspecialchars($recording['thumb_url']);?>">
		</a>
		<div class="media-body">
			<h2 class="media-heading"><?=htmlspecialchars($recording['title']);?></h2>
			<?=$recording['description_full'];?>
		</div>
	</div>

	<div class="row pad-below">
		<div class="span9">
			<div id='audio-player'></div>
			<script type='text/javascript'>
				jwplayer('audio-player').setup({
					file: '<?=htmlspecialchars($recording['url']);?>',
					width: '100%',
					height: '28',
					autostart: true
				});
			</script>
		</div>
		<div class="span3">
			<button id="new-quote-toggle" type="button" class="btn btn-primary" data-active-text="Mark end of quote">
				<i class="icon-quote-left"></i> Quote this recording
			</button>
		</div>
	</div>

	<div id="new-quote" class="collapse">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="start">Start and finish time</label>
				<div class="controls controls-row">

					<div class="input-append">
						<input class="span1" name="start" type="text" value="0:00">
						<button class="btn quote-seek" type="button" data-quote-seek="start" data-quote-seek-dir="back">&lt;</button>
						<button class="btn quote-seek" type="button" data-quote-seek="start" data-quote-seek-dir="fwd">&gt;</button>
					</div>

					<div class="input-append">
						<input class="span1" name="end" type="text" value="0:00">
						<button class="btn quote-seek" type="button" data-quote-seek="end" data-quote-seek-dir="back">&lt;</button>
						<button class="btn quote-seek" type="button" data-quote-seek="end" data-quote-seek-dir="fwd">&gt;</button>
					</div>

					<button class="btn quote-preview" type="button">Play quotation</button>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="summary">Describe the quote</label>
				<div class="controls">
					<input class="input-block-level" name="summary" type="text" value="">
					<span class="help-block">
						Please provide a summary of the quote in 80 characters or less
					</span>
				</div>
			</div>

			<?php
				$suggested_speakers = array();
				foreach ($recording['related_authors'] as $author):
					$suggested_speakers[] = $author['forename'].' '.$author['surname'];
				endforeach;
				$default_speaker = (count($suggested_speakers) === 1) ? $suggested_speakers[0] : '';

			?>
			<div class="control-group">
				<label class="control-label" for="speaker">Who is speaking?</label>
				<div class="controls">
					<input name="speaker"
						   type="text"
						   value="<?=htmlentities($default_speaker);?>"
						   autocomplete="off"
						   data-provide="typeahead"
						   data-source="<?=htmlentities(json_encode($suggested_speakers));?>"
						>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">This quote is:</label>
				<div class="controls">
					<label class="checkbox inline">
						<input type="checkbox" name="is_provocative" value="1"> Provocative
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="is_inspiring" value="1"> Inspiring
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="is_meaningful" value="1"> Meaningful
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="is_amusing" value="1"> Amusing
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="is_amusing" value="1"> Intriguing
					</label>
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save Quotation</button>
				<button type="submit" class="btn">
					<i class="icon-facebook"></i> Share on Facebook
				</button>
				<button type="submit" class="btn">
					<i class="icon-twitter"></i> Share on Twitter
				</button>
				<button type="submit" class="btn">
					<i class="icon-envelope"></i> Share by Email
				</button>
			</div>
		</form>
	</div>
</div>
