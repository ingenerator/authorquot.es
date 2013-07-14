<?php
/**
 * Basic layout template
 * 
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2013 inGenerator Ltd
 *
 * @var string  $content       The page content
 * @var string  $title         The page title - default ""
 */
if ( ! isset($title)) {
  $title = '';
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="utf-8">
  <title>
    <?php if ($title): ?>
      <?php echo $title; ?> | authorquot.es
    <?php else: ?>
      authorquot.es
    <?php endif; ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link href="/assets/css/authorquotes.css" rel="stylesheet">
	<script src="http://jwpsrv.com/library/39l4UuvYEeKpqBIxOQulpA.js"></script>
</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="#">authorquot.es</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li><a href="/">Home</a></li>
		  <li><a href="/recordings">Recordings</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<div class="container">
  <?php echo $content; ?>

  <footer>
    <p class="credit">Built by <a href="http://www.ingenerator.com/">inGenerator</a>.</p>
  </footer>
</div>
<!-- /container -->

<!-- Javascript -->
<script src="http://code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="/assets/js/jquery.form.min.js"></script>
<script src="/assets/js/quote_builder.js"></script>

</body>
</html>

