<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'db.html';

session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form data (you can add more validation as per your requirements)
    if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        // Handle form validation errors
        $error = "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        // Handle password mismatch error
        $error = "Passwords do not match.";
    } else {
        // Insert user data into the table
        $sql = "INSERT INTO users (name, username, email, phone_number, password, confirm_password)
                VALUES ('$name', '$username', '$email', '$phone', '$password', '$confirmPassword')";

        if ($conn->query($sql) === TRUE) {
            // User registration successful
            $_SESSION['username'] = $username;
            header("Location: index.html"); // Redirect to the dashboard page
            exit();
        } else {
            // Handle database error
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>