<?php
/**
 * View template for the homepage
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var string $category_preview a preview of quotes from each categroy
 * @var string $incoming_number  the number to phone the app on
 */

?>
<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <h1>authorquot.es</h1>
  <p>
    Find and share quotes of authors saying interesting things at the
    <a href="https://www.edbookfest.co.uk/">Edinburgh International Book Festival</a>.<br/>
	<small>
		This is a proof-of-concept hack for Culture Hack Scotland and will be taken down within the next 48 hours. If you
		don't know what Culture Hack Scotland is, sorry, but you're not supposed to be looking at this site.
	</small>
  </p>
  <p>
	<a class="btn btn-large btn-primary" href="/recordings">View all recordings</a>
	<i class="icon-phone"></i> Get quotes from your phone - <?=str_replace('+44', '0', $incoming_number);?>
  </p>
</div>

<?=$category_preview;?>
