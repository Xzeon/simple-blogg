<!doctype html>
<html class="no-js" lang="sv">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Datbaskonfiguration</title>
    <link rel="stylesheet" href="css/app.css" />
    <script src="/bower_components/modernizr/modernizr.js"></script>
</head>
    <body>
		<div class="row">
            <div class="large-6 medium-7 small-10 columns large-centered medium-centered small-centered">
                <header>
                    <h1>Databaskonfiguration</h1>
                    <p>Koppla upp dig mot en databas.</p>
                </header>

                <?php if (isset($data) && $data) : ?>

                    <p class="alert-box alert"> <?= $data ?> </p>

                <?php endif; ?>

                <form class="input-styles" action="" method="post">

                    <label for="dbname">Databas:</label>
                    <input type="text" name="dbname" id="dbname" value="<?= isset($_POST['dbname']) ? $_POST['dbname'] : ''; ?>">

                    <label for="dbuser">Användarnamn:</label>
                    <input type="text" name="dbuser" id="dbuser" value="<?= isset($_POST['dbuser']) ? $_POST['dbuser'] : ''; ?>">

                    <label for="dbpass">Lösenord:</label>
                    <input type="text" name="dbpass" id="dbpass" value="<?= isset($_POST['dbpass']) ? $_POST['dbpass'] : ''; ?>">

                    <input type="submit" name="setup_submit" class="button large expand" value="Klar">

                </form>
            </div>
        </div>
	</body>
</html>
