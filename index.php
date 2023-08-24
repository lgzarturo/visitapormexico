<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\WebPage;

$page = WebPage::init("Calculator", "Simple Calculator App");

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
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Complete the form below
                            </h2>
                        </div>
                        <form action="src/Examples/Calculator/Operation.php" method="POST">
                            <div class="card__body">
                                <div class="card__text">
                                    <fieldset>
                                        <legend>
                                            Please fill out the form below to generate a random image
                                        </legend>
                                        <div class="field">
                                            <label for="width" class="field__label field__label--required">First Number:</label>
                                            <input type="number" class="field__input" name="firstNumber" placeholder="" required>
                                            <span id="width__helper" class="field__helper"></span>
                                            <span id="width__feedback" class="field__feedback"></span>
                                        </div>
                                        <div class="field">
                                            <label for="height" class="field__label field__label--required">Second Number:</label>
                                            <input type="number" class="field__input" name="secondNumber" placeholder="" required>
                                            <span id="height__helper" class="field__helper"></span>
                                            <span id="height__feedback" class="field__feedback"></span>
                                        </div>
                                        <div class="field">
                                            <label for="filter" class="field__label">Filter:</label>
                                            <select class="field__input" name="filter" id="filter" required>
                                                <option value="">Please select a filter</option>
                                                <option value="+">+</option>
                                                <option value="-">-</option>
                                                <option value="*">*</option>
                                                <option value="/">/</option>
                                            </select>
                                            <span class="field__helper"></span>
                                            <span class="field__feedback"></span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="card__footer">
                                <button type="submit" class="btn btn--primary card__button">Button</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Result: <span class="card__title--normal">Random Image</span>
                            </h2>
                        </div>
                        <div class="card__body">
                            <div id="random__image">

                            </div>
                        </div>
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
    <script>
        $(document).ready(function() {});
    </script>
    <!-- version <?php echo $page->getFramework()->getVersion() ?> -->
</body>

</html>
