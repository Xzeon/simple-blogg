<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> <?= $data['bloggconfig'][0]['title'] ?></title>
    <link rel="stylesheet" href="css/app.css" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
	<body>
		<div class="row container">
            <div class="large-9 medium-10 small-10 columns large-centered medium-centered small-centered">

			<?php if(isset($_SESSION['username'])) : include '_parts/AdminTopbar.php' ?>
			<?php else : ?>
				<a href="/login" class="button tiny login">Logga in</a>
			<?php endif; ?>

			<header>
				<h1 class="blogg-title" title="Till Startsidan">
					<a href="/"><?= $data['bloggconfig'][0]['title'] ?></a>
				</h1>			
			</header>

			<?php if ($data['posts']) : ?>
				
				<?php foreach ($data['posts'] as $value) : ?>
						
				<article>
					<header>
						<h2><?= $value['header'] ?></h2>
						<p class="date"> <?= $value['post_timestamp'] ?> </p>
					</header>
					<?= $value['body'] ?>
						
					<?php if (isset($data['comments']) && $data['comments']) : ?>

						<h3 id="comment">Kommentarer:</h3>

						<section class="comments">
						
							<?php foreach ($data['comments'] as $value) : ?>
								
								<div>
									<h5 class="author"> <span>av:</span> <?= $value['author'] ?> </h5>
                                    <hr>
									<p class="comment_date"> <?= $value['comment_timestamp'] ?> </p>

									<?php if(isset($_SESSION['username'])) : ?>
										<form action="" method="post">
											<button class="remove_comment" title="Ta bort kommentar" type="submit" name="remove_comment" value="<?= $value['id'] ?>"><i class="fa fa-times"></i></button>
										</form>
									<?php endif; ?>		

									<div class="body">
										<?= $value['body'] ?>	
									</div>
								</div>

							<?php endforeach; ?>

						</section>

					<?php endif; ?>

				</article>		

				<?php endforeach; ?>

			<?php endif; ?>
			
			<form action="#comment" method="post" class="input-styles">

				<h3>Lämna en kommentar:</h3>

				<?php if(isset($_POST['comment_submit'], $data['error']) && $data['error']) : ?>
					
					<p class="alert-box alert"> <?= $data['error'] ?> </p>

				<?php endif; ?>

				<p class="info">
					Följande HTML-taggar är tillåtna i kommentarfältet: <strong> em, strong, q, quote.</strong>
				</p>

				<label for="author">Namn:</label>
				<input type="text" name="author" id="author" value="<?= isset($_POST['author']) ? $_POST['author'] : ''; ?>">
				<label for="body">Kommentar:</label>
				<textarea name="body" id="body"><?= isset($_POST['body']) ? $_POST['body'] : ''; ?></textarea>
				<input type="submit" class="button large right" name="comment_submit" value="Kommentera">
			</form>
		    </div>
		</div>
	</body>
</html>