<?php
require_once(__DIR__ . '/../connection.php');
session_start();
Database::setUpConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminEmail = $_POST["e"] ?? '';
    $adminPassword = $_POST["p"] ?? '';

    if (empty($adminEmail)) {
        echo "<script>alert('Please enter your Email');window.location.href='adminLogin.php';</script>";
        exit;
    }
    if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid Email');window.location.href='adminLogin.php';</script>";
        exit;
    }
    if (empty($adminPassword)) {
        echo "<script>alert('Please enter your Password');window.location.href='adminLogin.php';</script>";
        exit;
    }

    // Use username (which is the email) for login
    $query = "SELECT * FROM `admins` WHERE `username` = ?";
    $stmt = Database::$connection->prepare($query);
    if ($stmt === false) {
        die("Error preparing statement: " . Database::$connection->error);
    }
    $stmt->bind_param("s", $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        // Compare plain text password
        if ($adminPassword === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: adminDashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password');window.location.href='adminLogin.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid Username or Password');window.location.href='adminLogin.php';</script>";
        exit;
    }
}
