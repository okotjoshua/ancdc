<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'db.html';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate form data (you can add more validation as per your requirements)
    if (empty($username) || empty($password)) {
        // Handle form validation errors
        $error = "Username and password are required.";
    } else {
        // Check user credentials in the database
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            // User login successful
            $_SESSION['username'] = $username;
            header("Location: index.html"); // Redirect to the index page
            exit();
        } else {
            // Handle invalid credentials
            $error = "Invalid username or password.";
        }
    }
}
?>