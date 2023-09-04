<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $object->title ?></title>
</head>
<body>
    <h1><?php echo $object->title ?></h1>
    <h2><?php echo $object->description ?></h2>
    <div>
        <?php echo $object->content ?>
    </div>
</body>
</html>
