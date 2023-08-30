<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Core\Application;
use App\Helpers\Functions;

$page = Application::init('Task', 'Task Manager App');

$notification = isset($_SESSION['notification']) ? $_SESSION['notification'] : null;

$tasks = isset($_SESSION['tasks']) ? $_SESSION['tasks'] : null;
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
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Complete the form below
                            </h2>
                        </div>
                        <form action="src/Examples/TaskManager/Task.php" method="POST">
                            <div class="card__body">
                                <div class="card__text">
                                    <fieldset>
                                        <legend>

                                        </legend>
                                        <div class="field">
                                            <label for="width" class="field__label field__label--required">Task:</label>
                                            <input type="text" class="field__input" name="task" placeholder="" required>
                                            <span id="width__helper" class="field__helper"></span>
                                            <span id="width__feedback" class="field__feedback"></span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="card__footer">
                                Please push "Enter"
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card__header">
                            <h2 class="card__title">
                                Result: <span class="card__title--normal">Tasks</span>
                            </h2>
                        </div>
                        <div class="card__body">
                            <div id="tasks">
                                <?php if ($tasks) : ?>
                                    <ul>
                                        <?php foreach (array_reverse($tasks) as $task) : ?>

                                            <li>
                                                <?php if ($task->isCompleted()) : ?>
                                                    <s><?php echo $task ?></s>
                                                <?php else : ?>
                                                    <?php echo $task ?>
                                                <?php endif; ?>
                                                &nbsp;
                                                <a href="src/Examples/TaskManager/Task.php?id=<?php echo $task->getId() ?>&action=delete">Borrar</a>
                                                &nbsp;
                                                <a href="src/Examples/TaskManager/Task.php?id=<?php echo $task->getId() ?>&action=edit">Editar</a>
                                                &nbsp;
                                                <a href="src/Examples/TaskManager/Task.php?id=<?php echo $task->getId() ?>&action=complete">Completar</a>
                                            </li>

                                        <?php endforeach; ?>
                                    </ul>
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
