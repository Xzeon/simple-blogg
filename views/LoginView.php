<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> <?= $data['bloggconfig'][0]['title']?> - Login</title>
    <link rel="stylesheet" href="css/app.css" />
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
	<body>
		<div class="row">
            <div class="large-5 medium-6 small-8 columns large-centered medium-centered small-centered">
                <?php if(isset($_SESSION['username'])) { include '_parts/AdminTopbar.php'; } ?>

                <header>
                    <h1 class="blogg-title" title="Till Startsidan"><a href="/"><?= $data['bloggconfig'][0]['title'] ?></a></h1>
                </header>

                <form class="loginform" action="" method="post">

                    <?php if(isset($_POST['login_submit'], $data['error'])) : ?>

                        <p class="alert-box alert"> <?= $data['error'] ?> </p>

                    <?php endif; ?>

                    <h2>Inloggning:</h2>
                    <input type="text" id="login_username" name="login_username" placeholder="Användarnamn">
                    <input type="password" id="login_password" name="login_password" placeholder="Lösenord">
                    <input type="submit" value="Logga in" class="button large expand" name="login_submit">
                </form>
            </div>
            </div>
	</body>
</html>
