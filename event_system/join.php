<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$event_id = $_GET['id'];

$check = $conn->prepare("SELECT * FROM registrations WHERE user_id=? AND event_id=?");
$check->execute([$user_id, $event_id]);
if ($check->rowCount() == 0) {
    $stmt = $conn->prepare("INSERT INTO registrations(user_id, event_id) VALUES(?, ?)");
    $stmt->execute([$user_id, $event_id]);
    echo "<script>alert('Joined Successfully'); window.location='dashboard.php';</script>";
} else {

    echo "<script>alert('Already Joined'); window.location='dashboard.php';</script>";
}
?>