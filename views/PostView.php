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
                <a class="button tiny login" href="/login">Logga in</a>
            <?php endif; ?>

            <header>
                <h1 class="blogg-title" title="Till Startsidan"><a href="/"><?= $data['bloggconfig'][0]['title'] ?></a></h1>
            </header>

            <?php if ($data['posts']) : ?>

                <?php foreach ($data['posts'] as $value) : ?>

                    <article>
                        <header>
                            <h2><a href="<?= '/' . $value['uri'] ?>"> <?= $value['header'] ?> </a></h2>
                            <p class="date"> <?= $value['post_timestamp'] ?> </p>

                            <?php if(isset($_SESSION['username'])) : ?>
                                <form action="" method="post">
                                    <button class="remove" name="remove_post" value=" <?= $value['id'] ?>" type="submit" title="Ta bort"><i class="fa fa-times"></i></button>
                                </form>
                                <form action="/admin/edit" method="post">
                                    <button class="edit" name="edit_post" value=" <?= $value['id'] ?>" type="submit" title="Editera"><i class="fa fa-pencil"></i></button>
                                </form>
                            <?php endif; ?>

                        </header>

                        <?= $value['body'] ?>

                        <?php if($value['readmore']) : ?>
                            <a href="<?= '/' . $value['uri'] ?>" class="readmore" >Läs hela →</a>
                        <?php endif; ?>
                    </article>

                <?php endforeach; ?>

            <?php else : ?>
                <h2 class="no_posts">Inget inlägg har publicerat än.</h2>
            <?php endif; ?>
       </div>
    </div>
</body>
</html>