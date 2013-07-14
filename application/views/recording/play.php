<?php
/**
 * View the details and player of a single recording together with the main player and clip editor
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var Model_Recording $recording the recording model
 * @var boolean         $auto_play whether to automatically play
 */
?>
<div class="container">
	<div class="media">
		<a class="pull-left">
			<img class="media-object" src="<?=htmlspecialchars($recording->thumb_url);?>">
		</a>
		<div class="media-body">
			<h2 class="media-heading"><?=htmlspecialchars($recording->title);?></h2>
			<?=$recording->description_full;?>
		</div>
	</div>

	<div class="row pad-below">
		<div class="span9">
			<script type="text/javascript">
				window.main_recording = <?=json_encode($recording->url); ?>;
				window.autoplay = <?=json_encode($auto_play);?>
			</script>
			<div id='audio-player'>
				<img src="/assets/img/spinner.gif" height="28px">
			</div>
		</div>
		<div class="span3">
			<button id="new-quote-toggle" type="button" class="btn btn-primary" data-active-text="Mark end of quote">
				<i class="icon-quote-left"></i> Mark a new quote
			</button>
		</div>
	</div>

	<div id="new-quote" class="collapse">
		<form id="new-quote-form" class="form-horizontal" method="post" action="/recording/<?=$recording->id;?>/quotes">
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
				<label class="control-label" for="description">Describe the quote</label>
				<div class="controls">
					<input class="input-block-level" name="description" type="text" value="">
					<span class="help-block">
						Please provide a summary of the quote in 80 characters or less
					</span>
				</div>
			</div>

			<?php
				$suggested_speakers = array();
				foreach ($recording->Authors->find_all() as $author):
					/** @var Model_Author $author */
					$suggested_speakers[] = $author->name;
				endforeach;
				$default_speaker = (count($suggested_speakers) === 1) ? $suggested_speakers[0] : '';

			?>
			<div class="control-group">
				<label class="control-label" for="speakers">Who is speaking?</label>
				<div class="controls">
					<input name="speakers"
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
						<input type="checkbox" name="provocative" value="1"> Provocative
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="inspiring" value="1"> Inspiring
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="meaningful" value="1"> Meaningful
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="amusing" value="1"> Amusing
					</label>
					<label class="checkbox inline">
						<input type="checkbox" name="intriguing" value="1"> Intriguing
					</label>
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Save Quotation</button>
				<p>You will be able to share your quotation once it is saved.</p>
				<!--
				<button type="submit" class="btn">
					<i class="icon-facebook"></i> Share on Facebook
				</button>
				<button type="submit" class="btn">
					<i class="icon-twitter"></i> Share on Twitter
				</button>
				<button type="submit" class="btn">
					<i class="icon-envelope"></i> Share by Email
				</button>
				-->
			</div>
		</form>
	</div>
</div>

<div id="new-quote-submit-modal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
	</div>
	<div class="modal-body">
		<p class="text-center">
			<img src="/assets/img/spinner.gif"><br/>
			Please wait while we save and process your quotation.
		</p>
	</div>
	<div class="modal-footer">
	</div>
</div>

<?=View::factory('recording/quote_table')
	->set('recording', $recording)
	->set('quotes', $recording->Quotes->find_all())
	->render();?>
