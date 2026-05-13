<?php
session_start();
include 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("UPDATE events SET name=?, location=?, event_date=?, event_time=? WHERE id=? AND user_id=?");

    $stmt->execute([
        $_POST['name'],
        $_POST['location'],
        $_POST['event_date'],
        $_POST['event_time'],
        $id,
        $_SESSION['user_id']
    ]);

    echo "<script>alert('Updated Successfully'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Update Event</h2>

<form method="POST">
<input type="text" name="name" value="<?php echo $event['name']; ?>">
<input type="text" name="location" value="<?php echo $event['location']; ?>">
<input type="date" name="event_date" value="<?php echo $event['event_date']; ?>">
<input type="time" name="event_time" value="<?php echo $event['event_time']; ?>">
<button>Update</button>
</form>

</body>
</html>