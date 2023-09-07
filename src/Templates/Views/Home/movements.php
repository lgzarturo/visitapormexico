{{ extends:main }}
<?php

use App\Helpers\Functions;

Functions::showNotification();

echo '<h1>Movimientos</h1>';

?>
<script type="text/javascript">
$(document).ready(function() {

    /*
    // Ejemplo de uso de toastr
    toastr.warning("My name is Arturo", "Title", {
        "positionClass": "toast-top-right",
        "closeButton": true,
        "progressBar": true,
        "timeOut": "5000",
        "extendedTimeOut": "2000"
    });

    // Ejemplo de uso de waitMe
    $('body').waitMe({
        effect: 'ios',
        text: 'Cargando...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        waitTime: -1,
        textPos: 'vertical',
        fontSize: '',
        source: '',
        onClose: function() {}
    });
    */

    function addMovement(event) {}

    function getMovement() {}

    function updateMovement() {}

    function deleteMovement() {}
});
</script>
