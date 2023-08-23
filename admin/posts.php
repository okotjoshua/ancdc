<?php
// Assuming you have established a database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'db.html';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];


    // Validate form data (you can add more validation as per your requirements)
    if (empty($title) || empty($date) || empty($description)) {
        // Handle form validation errors
        $error = "All fields are required.";
    } else {
        // Handle image upload
        $image = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];

        // Prepare and execute the SQL statement
        $sql = "INSERT INTO posts (title, date, description, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $date, $description, $imageName);

        if ($stmt->execute()) {
            // Move uploaded image to a directory (you can modify the directory path as per your needs)
            $targetDirectory = "uploads/";
            $targetPath = $targetDirectory . $imageName;
            move_uploaded_file($image, $targetPath);

            // Post insertion successful
            $successMessage = "Post created successfully!";
            echo '<script>
                setTimeout(function() {
                    alert("Post created successfully!");
                    window.location.href = "index.html";
                }, 3000);
            </script>';
        } else {
            // Handle database error
            $errorMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
