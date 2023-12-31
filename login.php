<?php

declare(strict_types=1);

require_once getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Crud\Users\Login;
use App\Helpers\Functions;
use App\Core\Application;

$app = Application::init('Login', 'User Login Page');

Login::logoutSession();

if (isset($_POST) && !empty($_POST)) {
    Login::authentication($_POST);
}
Login::getCurrentUser();

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

<body>
    <main>
        <div class="container">
            <h1><?php echo $app->getTitle() ?></h1>
            <p><?php echo $app->getDescription() ?></p>
        </div>

        <?php Functions::showNotification() ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="" method="POST" class="card__form">
                            <div class="card__header">
                                <h2 class="card__title">
                                    Login form
                                </h2>
                            </div>
                            <div class="card__body">
                                <fieldset>
                                    <legend>
                                        Please login to continue to the dashboard application
                                    </legend>
                                    <div class="field">
                                        <label for="username" class="field__label field__label--required">Username:</label>
                                        <input type="text" class="field__input" name="username" placeholder="Enter your username" tabindex="1" required autofocus autocomplete="off">
                                        <span id="width__helper" class="field__helper"></span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                    <div class="field">
                                        <label for="password" class="field__label field__label--required">Password:</label>
                                        <input type="password" class="field__input" name="password" id="password" placeholder="Please enter your password" tabindex="2" required autocomplete="off">
                                        <span id="width__helper" class="field__helper"></span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                    <div class="field">
                                        <input type="checkbox" class="field__input" name="show_password" id="show_password" tabindex="3">
                                        <label for="show_password" class="field__label">Show password</label>
                                        <span id="width__helper" class="field__helper"></span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card__footer">
                                <button type="submit" class="btn btn--primary" tabindex="4">Proceed to login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
