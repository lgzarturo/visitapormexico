{{ extends:main }}
<style>
    h1 {
        color: red;
    }
</style>
<?php

use App\Helpers\Functions;

Functions::showNotification();

echo '<h1>Hola mundo</h1>';

echo '<pre>';
var_dump($object);
echo '</pre>';

?>
<script type="text/javascript">
    console.log('<?php echo $object->salt; ?>');
</script>
