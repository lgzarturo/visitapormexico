<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Crud\Users\{Create, Delete, ListItems, Read, Update};
use App\Functions;
use App\Models\{Amenity, Gallery, Hotel, Photo, Room, User};
use App\WebPage;

$page = WebPage::init("Exercises", "Php Exercises App - Home Page");

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
                        <div class="card__header">
                            <h2 class="card__title">
                                List of Exercises
                            </h2>
                        </div>
                        <div class="card__body">
                            <div class="card__text">
                                <ul>
                                    <li><a href="calculator.php">Calculator</a></li>
                                    <li><a href="password.php">Password</a></li>
                                    <li><a href="process_image.php">Image Random</a></li>
                                    <li><a href="tasks.php">Task Manager</a></li>
                                    <li><a href="users.php">User Manager</a></li>
                                </ul>
                            </div>

                            <h3>Models</h3>
                            <ul>
                                <li><?php new Amenity() ?></li>
                                <li><?php new Gallery() ?></li>
                                <li><?php new Hotel() ?></li>
                                <li><?php new Photo() ?></li>
                                <li><?php new Room() ?></li>
                                <li><?php new User() ?></li>
                            </ul>

                            <h3>Crud</h3>
                            <ul>
                                <li><?php new Create() ?></li>
                                <li><?php new Delete() ?></li>
                                <li><?php new ListItems() ?></li>
                                <li><?php new Read() ?></li>
                                <li><?php new Update() ?></li>
                            </ul>
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
