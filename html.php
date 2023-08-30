<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Functions;
use App\WebPage;

$page = WebPage::init('Exercises', 'HTML y Javascript Exercises App - Home Page');

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
                            <video id="camera" autoplay></video>
                            <button id="take-picture">Take Picture</button>
                            <button id="stop-camera">Stop Camera</button>
                            <button id="reset-camera">Reset Camera</button>
                            <button id="close-camera">Close Camera</button>
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
        const streamCamera = document.getElementById('camera');

        if (streamCamera) {
            const stopCamera = document.getElementById('stop-camera');
            const resetCamera = document.getElementById('reset-camera');
            const closeCamera = document.getElementById('close-camera');
            const takePicture = document.getElementById('take-picture');
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    streamCamera.srcObject = stream;
                })
                .catch(function(error) {
                    console.log("Something went wrong accessing the camera", error);
                });
            stopCamera.addEventListener('click', function() {
                streamCamera.srcObject.getTracks().forEach(function(track) {
                    track.stop();
                });
            });
            resetCamera.addEventListener('click', function() {
                if (streamCamera.srcObject) {
                    streamCamera.srcObject.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        streamCamera.srcObject = stream;
                    })
                    .catch(function(error) {
                        console.log('Something went wrong accessing the camera', error);
                    });
            });
            closeCamera.addEventListener('click', function() {
                streamCamera.srcObject.getTracks().forEach(function(track) {
                    track.stop();
                });
                streamCamera.srcObject = null;
            });
            takePicture.addEventListener('click', function() {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = streamCamera.videoWidth;
                canvas.height = streamCamera.videoHeight;
                context.drawImage(streamCamera, 0, 0);
                const data = canvas.toDataURL('image/png');
                const image = document.createElement('img');
                image.src = data;
                document.body.appendChild(image);
            });
        }

        window.addEventListener('beforeunload', function(e) {
            if (streamCamera.srcObject) {
                streamCamera.srcObject.getTracks().forEach(function(track) {
                    track.stop();
                });
            }
            e.preventDefault();
            e.returnValue = '';
        });

        $(document).ready(function() {});
    </script>
    <!-- version <?php echo $page->getFramework()->getVersion() ?> -->
</body>

</html>
