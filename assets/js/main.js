// If the jQuery is not working, make sure you have the jQuery library loaded in the head of your document
$(document).ready(function() {
  // Add dynamic back to home link and logout link
  if (window.location.pathname !== '/index.php') {
    // TODO: The logout link should be dynamic if the user is logged in or not
    $('body').prepend('<div class="container"><a href="/index.php">Back to Home</a>&nbsp;<a href="/login.php?action=logout">Logout</a</div>');
  }
  // Slide up notifications after 3 seconds
  //$('.notification').delay(3000).slideUp(300);
  // Open dialog if user is not logged in
  const element = document.getElementById("user_dialog");
  if (element) {
    element.open = true;
  }
});

// Function to show password when certain checkbox is checked
const showPassword = document.getElementById('show_password');
const password = document.getElementById('password');

if (showPassword && password) {
  showPassword.onchange = function () {
    password.type = this.checked ? 'text' : 'password';
  }
}
