$(document).ready(function() {
  if (window.location.pathname !== '/index.php') {
    $('body').prepend('<div class="container"><a href="/index.php">Back to Home</a></div>');
  }
  $('.notification').delay(3000).slideUp(300);
});
