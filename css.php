<?php

declare(strict_types=1);

require_once getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Core\Application;

$app = Application::init('CSS Exercises', 'CSS Practice Exercises App - Home Page');

$theme = $_GET['theme'] ?? 'light';

// TODO: Move this code to a Pages directory.
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $app->getTitle() ?></title>
    <meta name="description" content="<?php echo $app->getDescription() ?>">
    <link rel="stylesheet" href="assets/css/normalize.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
</head>

<body class="<?php echo $theme ?>">
    <main>
        <section class="section container header">
            <h1 class="title"><?php echo $app->getTitle() ?></h1>
            <p class="subtitle"><?php echo $app->getDescription() ?></p>
            <p class="lead">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum. <br>
                <a href="?theme=light">Light theme</a>&nbsp;|&nbsp;<a href="?theme=dark">Dark theme</a>
            </p>
        </section>

        <section class="section container">
            <div class="section__header">
                <h3 class="section__title">Type of notifications</h3>
                <p class="section__subtitle">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--primary">Primary
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--secondary">Secondary
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--tertiary">Tertiary
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--success">Success
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--warning">Warning
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--danger">Error
                    <button class="notification__button">&times;</button>
                </p>
            </div>
            <div class="notification">
                <p class="notification__text notification--info">Info
                    <button class="notification__button">&times;</button>
                </p>
            </div>
        </section>

        <section class="section container">
            <h3 class="section__title">Card Element</h3>
            <p class="section__subtitle">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.
            </p>
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--primary">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--secondary">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--tertiary">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--success">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--warning">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--danger">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header card__header--info">
                            <h2 class="card__title">
                                Card title
                            </h2>
                        </div>
                        <div class="card__body">
                            Card body
                        </div>
                        <div class="card__footer">
                            Card Footer
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section container">
            <h3 class="section__title">Typography</h3>
            <p class="section__subtitle">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.
            </p>

            <h1>Heading 1</h1>
            <h2>Heading 2</h2>
            <h3>Heading 3</h3>
            <h4>Heading 4</h4>
            <h5>Heading 5</h5>
            <h6>Heading 6</h6>

            <p class="h1">Heading 1</p>
            <p class="h2">Heading 2</p>
            <p class="h3">Heading 3</p>
            <p class="h4">Heading 4</p>
            <p class="h5">Heading 5</p>
            <p class="h6">Heading 6</p>

            <div>
                <a href="#">This is a simple link.</a>
            </div>

            <p class="lead">This is a lead paragraph.</p>

            <p>This is a paragraph.</p>

            <p>
                <strong>This is a strong paragraph.</strong>
            </p>

            <p>
                <em>This is an emphasized paragraph.</em>
            </p>

            <p>
                <small>This is a small paragraph.</small>
            </p>

            <p>
                <mark>This is a marked paragraph.</mark>
            </p>

            <p>
                <del>This is a deleted paragraph.</del>
            </p>

            <p>
                <ins>This is an inserted paragraph.</ins>
            </p>

            <p>
                <sub>This is a subscript paragraph.</sub>
            </p>

            <p>
                <sup>This is a superscript paragraph.</sup>
            </p>

            <p>
                <abbr title="This is an abbreviation">This is an abbreviation</abbr>
            </p>

            <p>
                <q>This is a short quotation.</q>
            </p>

            <blockquote>This is a long quotation.</blockquote>

            <p>
                <cite>This is a citation.</cite>
            </p>

            <p>
                <code>This is a code.</code>
            </p>

            <p>
                <kbd>This is a keyboard input.</kbd>
            </p>

            <p>
                <samp>This is a sample output.</samp>
            </p>

            <p>
                <var>This is a variable.</var>
            </p>

            <p>
                <a href="#">This is a link.</a>
            </p>

            <p>
                <a href="#" class="link--primary">This is a primary link.</a>
            </p>

            <p>
                <a href="#" class="link--secondary">This is a secondary link.</a>
            </p>

            <p>
                <a href="#" class="link--tertiary">This is a tertiary link.</a>
            </p>

            <p>
                <a href="#" class="link--success">This is a success link.</a>
            </p>

            <p>
                <a href="#" class="link--warning">This is a warning link.</a>
            </p>

            <p>
                <a href="#" class="link--danger">This is a danger link.</a>
            </p>

            <p>
                <a href="#" class="link--info">This is a info link.</a>
            </p>

            <ul>
                <li>This is a list item.</li>
                <li>This is a list item.</li>
                <li>This is a list item.</li>
                <li>This is a nested list item:
                    <ul>
                        <li>This is a nested list item.</li>
                        <li>This is a nested list item.</li>
                        <li>This is a nested list item.</li>
                    </ul>
                </li>
            </ul>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <?php echo $app->getFramework()->getCopyRight() ?>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="assets/js/main.min.js" type="application/javascript"></script>
    <script>
        $(document).ready(function() {});
    </script>
    <!-- version <?php echo $app->getFramework()->getVersion() ?> -->
</body>

</html>
