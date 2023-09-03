<?php

declare(strict_types=1);

require_once getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Helpers\Functions;
use App\Core\Application;

$app = Application::init('Random Image', 'Generate a random image with the Picsum API');

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : null;

$image = isset($_SESSION['image']) ? $_SESSION['image'] : null;

$defaultWidth = 1000;

$defaultHeight = 1000;

$defaultFilter = '';

if ($image !== null) {
    $defaultWidth = $image['width'];
    $defaultHeight = $image['height'];
    $defaultFilter = $image['filter'];
}

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
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Complete the form below
                            </h2>
                        </div>
                        <form action="src/Examples/ImageRandom/ProcessImage.php" method="POST">
                            <div class="card__body">
                                <div class="card__text">
                                    <fieldset>
                                        <legend>
                                            Please fill out the form below to generate a random image
                                        </legend>
                                        <div class="field">
                                            <label for="width" class="field__label field__label--required">Width:</label>
                                            <input type="range" class="field__input" name="width" id="width" placeholder="Please select a width" min="0" max="2000" step="100" value="<?php echo $defaultWidth ?>" required>
                                            <span id="width__helper" class="field__helper"></span>
                                            <span id="width__feedback" class="field__feedback"></span>
                                        </div>
                                        <div class="field">
                                            <label for="height" class="field__label field__label--required">Height:</label>
                                            <input type="range" class="field__input" name="height" id="height" placeholder="Please select a height" min="0" max="2000" step="100" value="<?php echo $defaultHeight ?>" required>
                                            <span id="height__helper" class="field__helper"></span>
                                            <span id="height__feedback" class="field__feedback"></span>
                                        </div>
                                        <div class="field">
                                            <label for="filter" class="field__label">Filter:</label>
                                            <select class="field__input" name="filter" id="filter">
                                                <option value="">Please select a filter</option>
                                                <option value="grayscale" <?php echo $defaultFilter === 'grayscale' ? 'selected' : '' ?>>Grayscale</option>
                                                <option value="sepia" <?php echo $defaultFilter === 'sepia' ? 'selected' : '' ?>>Sepia</option>
                                                <option value="blur" <?php echo $defaultFilter === 'blur' ? 'selected' : '' ?>>Blur</option>
                                                <option value="sharpen" <?php echo $defaultFilter === 'sharpen' ? 'selected' : '' ?>>Sharpen</option>
                                                <option value="emboss" <?php echo $defaultFilter === 'emboss' ? 'selected' : '' ?>>Emboss</option>
                                                <option value="edges" <?php echo $defaultFilter === 'edges' ? 'selected' : '' ?>>Edges</option>
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
                                <?php if ($image !== null) : ?>
                                    <div id="random__image">
                                        <img src="<?php echo $image['url'] ?>" alt="Random Image" class="card__image responsive">
                                        <p class="badge__text">
                                            <?php echo $image['width'] ?>px x <?php echo $image['height'] ?>px
                                            <?php if ($image['filter']) : ?>
                                                <span class="badge badge--primary">(Filter: <?php echo $image['filter'] ?>)</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php unset($_SESSION['image']) ?>
                                <?php else : ?>
                                    <div id="no__image">
                                        <h3>(-''-)</h3>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
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
        $(document).ready(function() {
            const $width = $('#width');
            const $widthHelper = $('#width__helper');
            const $height = $('#height');
            const $heightHelper = $('#height__helper');
            const $filter = $('#filter');
            const $button = $('.card__button');
            const $result = $('#random__image');

            $widthHelper.text(`${$width.val()} px`);
            $heightHelper.text(`${$height.val()} px`);

            $width.on('input', function() {
                const value = $(this).val();
                $widthHelper.text(`${value} px`);
            });

            $height.on('input', function() {
                const value = $(this).val();
                $heightHelper.text(`${value} px`);
            });

            /* $button.on('click', function(e) {
                e.preventDefault();

                const width = $width.val();
                const height = $height.val();
                const filter = $filter.val();

                let url = `https://picsum.photos/${width}/${height}?${filter}`;
                if (width === height) {
                    url = `https://picsum.photos/${width}?${filter}`;
                }

                $result.html(`<img src="${url}" alt="Random Image" class="card__image responsive">`);
            });*/
        });
    </script>
    <!-- version <?php echo $app->getFramework()->getVersion() ?> -->
</body>

</html>
