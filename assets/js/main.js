$(document).ready(function() {
  if (window.location.pathname !== '/index.php') {
    $('body').prepend('<div class="container"><a href="/index.php">Back to Home</a>&nbsp;<a href="/login.php?action=logout">Logout</a</div>');
  }
  $('.notification').delay(3000).slideUp(300);
  const element = document.getElementById("user_dialog");
  if (element) {
    element.open = true;
  }
});

const showPassword = document.getElementById('show_password');
const password = document.getElementById('password');

if (showPassword && password) {
  showPassword.onchange = function () {
    password.type = this.checked ? 'text' : 'password';
  }
}
