<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Core\Application;
use App\Crud\Users\ListItems;
use App\Helpers\Functions;


$app = Application::init('Exercises', 'Php Exercises App - Home Page');

$users = ListItems::getAll();

$userEdit = isset($_SESSION['user']) ? $_SESSION['user'] : null;

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
                        <form action="<?php echo isset($userEdit) ? 'src/Crud/Users/Update.php' : 'src/Crud/Users/Create.php' ?>" method="POST" class="card__form">
                            <div class="card__header">
                                <h2 class="card__title">
                                    Form
                                </h2>
                            </div>
                            <div class="card__body">
                                <fieldset>
                                    <legend>
                                        Create a new user
                                    </legend>
                                    <div class="field">
                                        <label for="name" class="field__label field__label--required">Name:</label>
                                        <input type="text" class="field__input" name="name" placeholder="Please enter a name" value="<?php echo $userEdit['name'] ?? 'Gustavo' ?>" required>
                                        <span id="width__helper" class="field__helper"></span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                    <div class="field">
                                        <label for="email" class="field__label field__label--required">Email:</label>
                                        <input type="email" class="field__input" name="email" placeholder="Please enter a valid email" value="<?php echo $userEdit['email'] ?? 'gus@gmail.com' ?>" required>
                                        <span id="width__helper" class="field__helper"></span>
                                        <span id="width__feedback" class="field__feedback"></span>
                                    </div>
                                    <div class="field">
                                        <label for="status" class="field__label">Status:</label>
                                        <select class="field__input" name="status" required>
                                            <option value="">Please select a status</option>
                                            <option value="active" <?php echo $userEdit['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?php echo $userEdit['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                        <span class="field__helper"></span>
                                        <span class="field__feedback"></span>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="card__footer">
                                <?php if ($userEdit) : ?>
                                    <input type="hidden" name="id" value="<?php echo $userEdit['id'] ?>">
                                    <button type="submit" class="btn btn--primary">Update User</button>
                                <?php else : ?>
                                    <button type="submit" class="btn btn--primary">Add User</button>
                                <?php endif; ?>
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
                            <?php if (!empty($users)) : ?>
                                <div class="table--responsive">
                                    <table width="100%" class="table table--hover table--striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>
                                                <th width="30%">Name</th>
                                                <th width="40%">Email</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user) : ?>
                                                <tr>
                                                    <td><?php echo $user['id'] ?></td>
                                                    <td><?php echo $user['name'] ?></td>
                                                    <td><?php echo $user['email'] ?></td>
                                                    <td><?php echo $user['status'] ?></td>
                                                    <td>
                                                        <?php if ($user['status'] === 'active') : ?>
                                                            <a href="src/Crud/Users/UpdateStatus.php?id=<?php echo $user['id'] ?>&status=inactive">Deactivate</a>
                                                        <?php else : ?>
                                                            <a href="src/Crud/Users/UpdateStatus.php?id=<?php echo $user['id'] ?>&status=active">Activate</a>
                                                        <?php endif; ?>
                                                        <a href="src/Crud/Users/Read.php?id=<?php echo $user['id'] ?>">Edit</a>
                                                        <a href="src/Crud/Users/Delete.php?id=<?php echo $user['id'] ?>">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p>No users found</p>
                            <?php endif; ?>
                        </div>
                        <div class="card__footer">
                            This is the footer
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php Functions::showUser() ?>

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
