function logout() {
    let message = 'Click OK to log out'; // Confirmation message
    if (confirm(message)) { // Display confirmation dialog
        // If user confirms, redirect to logout.php
        window.location.href = "logout.php";
    } else {
        return; // Stop the function if user cancels the confirmation
    }
}
