<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
SELECT events.* FROM events 
JOIN registrations ON events.id = registrations.event_id 
WHERE registrations.user_id=?
");
$stmt->execute([$user_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>My Joined Events</h2>
<p style="margin-bottom:20px;">
    <a href="dashboard.php">Back</a>
</p>

<table border="1">
<tr>
<th>Name</th>
<th>Location</th>
<th>Date</th>
<th>Time</th>
</tr>

<?php foreach ($events as $row): ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['event_date']; ?></td>
<td><?php echo $row['event_time']; ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>