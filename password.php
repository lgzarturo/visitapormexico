<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\WebPage;

$page = WebPage::init("Random", "Generate Random Password and Number");

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : null;

$number = isset($_SESSION['number']) ? $_SESSION['number'] : null;

$numbers = isset($_SESSION['numbers']) ? $_SESSION['numbers'] : [];

$password = isset($_SESSION['password']) ? $_SESSION['password'] : null;

if (isset($_GET['restart'])) {
    unset($_SESSION['numbers']);
    unset($_SESSION['number']);
    unset($_SESSION['password']);
    unset($_SESSION['notification']);
    header('Location: /password.php');
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $page->getTitle() ?></title>
    <meta name="description" content="<?php echo $page->getDescription() ?>">
    <link rel="stylesheet" href="assets/css/normalize.min.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
</head>

<body>
    <main>
        <div class="container">
            <h1><?php echo $page->getTitle() ?></h1>
            <p><?php echo $page->getDescription() ?></p>
        </div>

        <div class="container">
            <?php if ($notification) : ?>
                <div class="notification">
                    <p class="notification__text <?php echo $notification['type'] === 'success' ? 'notification--success' : 'notification--error' ?>">
                        <?php echo $notification['content'] ?>
                    </p>
                </div>
                <?php unset($_SESSION['notification']) ?>
            <?php endif; ?>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Random Number
                            </h2>
                        </div>
                        <form action="src/Examples/Password/RandomNumber.php" method="POST">
                            <div class="card__body">
                                <?php if ($number) : ?>
                                    <?php echo $number ?>
                                    <?php unset($_SESSION['number']) ?>
                                <?php endif; ?>

                                <?php if ($numbers) : ?>
                                    <ul>
                                        <?php foreach (array_reverse($numbers) as $number) : ?>
                                            <li><?php echo $number ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="card__footer">
                                <input type="hidden" name="minLength" value="8">
                                <a href="/password.php?restart=true">Reset</a>&nbsp;
                                <button type="submit" class="btn btn--primary card__button">Button</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Random Password
                            </h2>
                        </div>
                        <form action="src/Examples/Password/SecurePassword.php" method="POST">
                            <div class="card__body">
                                <?php if ($password) : ?>
                                    <?php echo $password['password'] ?>
                                    <?php unset($_SESSION['password']) ?>
                                <?php endif; ?>

                                <div class="field">
                                    <label for="width" class="field__label field__label--required">Password Size:</label>
                                    <input type="number" class="field__input" name="size" placeholder="Select password size" value="<?php echo $password ? $password['size'] : '' ?>" required>
                                    <span id="width__helper" class="field__helper"></span>
                                    <span id="width__feedback" class="field__feedback"></span>
                                </div>
                            </div>
                            <div class="card__footer">
                                <input type="hidden" name="minLength" value="8">
                                <button type="submit" class="btn btn--primary card__button">Button</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <?php echo $page->getFramework()->getCopyRight() ?>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="assets/js/main.min.js" type="application/javascript"></script>
    <script>
        $(document).ready(function() {});
    </script>
    <!-- version <?php echo $page->getFramework()->getVersion() ?> -->
</body>

</html>
