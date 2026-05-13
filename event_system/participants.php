<?php
session_start();
include 'db.php';
$event_id = $_GET['id'];

$stmt = $conn->prepare("SELECT name FROM events WHERE id=?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
SELECT users.username, users.phone
FROM users 
JOIN registrations ON users.id = registrations.user_id 
WHERE registrations.event_id=?
");
$stmt->execute([$event_id]);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($participants);

?>
<!DOCTYPE html>
<html>
<head>
<title>Participants</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Participants for: <?php echo $event['name']; ?></h2>
<p style="text-align:center; font-weight:bold;">
    Total Participants: <?php echo $total; ?>
</p>

<div style="margin-bottom:20px;">
    <a href="dashboard.php" class="nav-btn">Back</a>
</div>

<table border="1">
<tr>
<th>Username</th>
<th>Contact</th>
</tr>
<?php if (count($participants) > 0): ?>
    <?php foreach ($participants as $p): ?>
    <tr>
       <td><?php echo $p['username']; ?></td>
       <td><?php echo $p['phone']; ?></td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td>No participants yet</td>
    </tr>
<?php endif; ?>
</table>
</body>
</html>