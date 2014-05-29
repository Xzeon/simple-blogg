<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> <?= $data['bloggconfig'][0]['title']?> - Editera inlägg</title>
    <link rel="stylesheet" href="/css/app.css" />
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
	<body>
		<div class="row container">
            <div class="large-10 medium-10 small-10 columns large-centered medium-centered small-centered">
			<?php if(isset($_SESSION['username'])) { include '_parts/AdminTopbar.php'; } ?>

			<h1 class="blogg-title" title="Till Startsidan"><a href="/"><?= $data['bloggconfig'][0]['title'] ?></a></h1>
			
			<h2>Editera inlägg</h2>

			<p class="info">
				Vid publicering kommer textstycken justeras automatiskt för varje mellanrum i texten. 
				HTML kan användas med de taggar som stöds: <strong>h3, h4, h5, strong, em, q, qoute, och img.</strong>
			</p>

			<?php if(isset($_POST['blogg_post_submit'], $data['error']) && $data['error']) : ?>
					
				<p class="alert-box alert"> <?= $data['error'] ?> </p>
				
			<?php endif; ?>

			<form class="input-styles" action="" method="post">
				<label for="header">Rubrik</label>
				<input type="text" id="header" name="header" value="<?= isset($data['post'][0]['header']) ? $data['post'][0]['header'] : $_POST['header']; ?>" >
				<label for="body">Inlägg:</label>
				<textarea name="body" id="body"><?= isset($data['post'][0]['body']) ? $data['post'][0]['body'] : $_POST['body']; ?></textarea>
				<input type="submit" name="blogg_post_submit" class="button large right" value="Uppdatera">
			</form>
            </div>
		</div>
	</body>
</html>