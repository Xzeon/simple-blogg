<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blogginställningar</title>
    <link rel="stylesheet" href="/css/app.css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
<body>
		<div class="row container">
            <div class="large-10 medium-10 small-10 columns large-centered medium-centered small-centered">
			<?php if(isset($_SESSION['username'])) { include '_parts/AdminTopbar.php'; } ?>

			<h1 class="blogg-title" title="Till Startsidan"><a href="/"><?= $data[0]['title'] ?></a></h1>
			
			<h2>Blogginställningar</h2>

			<p class="info">
				Här finns möjlighet att ändra bloggens titel.
			</p>

			<?php if(isset($_POST['config_submit'], $data[1]) && $data[1]) : ?>
					
				<p class="alert-box alert"> <?= $data[1] ?> </p>
				
			<?php endif; ?>

			<form class="input-styles" action="" method="post">
				<label for="title">Bloggtitel</label>
				<input type="text" id="title" name="title" value="<?= isset($_POST['header']) ? $_POST['header'] : ''; ?>">
				<input type="submit" name="config_submit" class="button large right" value="Uppdatera">
			</form>
            </div>
		</div>
	</body>
</html>