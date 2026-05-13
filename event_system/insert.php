<?php
session_start();
include 'db.php';
$stmt = $conn->prepare("INSERT INTO events(user_id, name, location, event_date, event_time) VALUES(?,?,?,?,?)");
$stmt->execute([
    $_SESSION['user_id'],
    $_POST['name'],
    $_POST['location'],
    $_POST['event_date'],
    $_POST['event_time']
]);

header("Location: dashboard.php");
?>