<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Crud\Products\Search;
use App\Functions;
use App\WebPage;

$page = WebPage::init('Search', 'Products Search Page');

$searchQuery = isset($_GET['term']) ? htmlspecialchars($_GET['term']) : null;

$results = [];

if ($searchQuery !== null) {
    $results = Search::execute(['term' => $searchQuery]);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
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

        <?php Functions::showNotification() ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="search.php" method="GET" class="card__form">
                            <div class="card__header">
                                <h2 class="card__title">
                                    Form
                                </h2>
                            </div>
                            <div class="card__body">
                                <fieldset>
                                    <legend>
                                        Search for a product
                                    </legend>
                                    <div class="field">
                                        <label for="term" class="field__label field__label--required">Term to search:</label>
                                        <input type="text" class="field__input" name="term" placeholder="What are you looking for?" value="<?php echo $searchQuery === null ? '' : $searchQuery ?>" required>
                                        <span id="width__helper" class="field__helper">
                                            Press enter to search products with the term you entered
                                        </span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card__footer">
                                <button type="submit" class="btn btn--primary">Search product</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Result
                            </h2>
                        </div>
                        <div class="card__body">
                            <?php if ($searchQuery !== null) : ?>
                                <?php if (!empty($results)) : ?>
                                    <p>
                                        The following products were found with the term <strong><?php echo $searchQuery ?></strong>
                                    </p>
                                    <ul>
                                        <?php foreach ($results as $result) : ?>
                                            <li>
                                                <a href="product.php?id=<?php echo $result['id'] ?>"><?php echo $result['title'] ?></a>&nbsp;
                                                <span class="badge badge--success">
                                                    <?php echo "$" . number_format((float)$result['price'], 2, '.', '') ?>
                                                </span>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                <?php else : ?>
                                    <p>No results found</p>
                                <?php endif ?>
                            <?php endif ?>
                        </div>
                        <div class="card__footer">
                            This is the footer
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
    <script defer src="assets/js/main.min.js" type="application/javascript"></script>
    <script>
        $(document).ready(function() {});
    </script>
    <!-- version <?php echo $page->getFramework()->getVersion() ?> -->
</body>

</html>
