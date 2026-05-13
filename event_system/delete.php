<?php
session_start();
include 'db.php';

$stmt = $conn->prepare("DELETE FROM events WHERE id=? AND user_id=?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);

echo "<script>alert('Deleted Successfully'); window.location='dashboard.php';</script>";
?>