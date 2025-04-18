<?php
session_start(); // Starts the session (if not already started)

// Check if a session variable is set
if (isset($_SESSION['user'])) {
    echo "Session is active. User: " . $_SESSION['user'];
} else {
    echo "No active session.";
}
?>
