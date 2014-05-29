<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrering</title>
    <link rel="stylesheet" href="css/app.css" />
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
<body>
    <div class="row">
            <div class="large-6 medium-7 small-10 columns large-centered medium-centered small-centered">
                <header>
                    <h1>Registrering</h1>
                    <p>Skapa ditt adminkonto, och börja publicera.</p>
                </header>


                <?php if (isset($data) && $data) : ?>

                    <p class="alert-box alert"> <?= $data ?> </p>

                <?php endif; ?>

                <form class="input-styles" action="" method="post">

                    <label for="username">Användarnamn:</label>
                    <input type="text" name="username" id="username" value="<?= isset($_POST['username']) ? $_POST['username'] : ''; ?>">

                    <label for="firstname">Förnamn:</label>
                    <input type="text" name="firstname" id="firstname" value="<?= isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>">

                    <label for="lastname">Efternamn:</label>
                    <input type="text" name="lastname" id="lastname" value="<?= isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>">

                    <label for="email">E-post:</label>
                    <input type="text" name="email" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>">

                    <label for="email_repeat">Upprepa e-post:</label>
                    <input type="text" name="email_repeat" id="email_repeat" value="<?= isset($_POST['email_repeat']) ? $_POST['email_repeat'] : ''; ?>">

                    <label for="password">Löseonord:</label>
                    <input type="password" name="password" id="password">

                    <label for="password_repeat">Upprepa lösenord:</label>
                    <input type="password" name="password_repeat" id="password_repeat">

                    <input type="submit" name="register_submit" class="button large expand" value="Registrera">

                </form>
            </div>
        </div>
	</body>
</html>