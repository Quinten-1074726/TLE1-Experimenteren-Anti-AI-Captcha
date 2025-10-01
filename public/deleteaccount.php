<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tle1-2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'error';
    exit;
}

$userId = $_SESSION['user_id'];

// Voorkom SQL-injectie, gebruik prepared statements
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // gebruiker uitloggen
    session_destroy();
    echo 'success';
} else {
    echo 'error';
}

$stmt->close();
$conn->close();

