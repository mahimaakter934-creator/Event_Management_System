<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role == 'manager') {
    $stmt = $conn->prepare("SELECT * FROM events WHERE user_id=?");
    $stmt->execute([$user_id]);
} else {
    $stmt = $conn->query("SELECT * FROM events");
}

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div style="text-align:right;">
    <a href="logout.php">Logout</a>
</div>

<h2>Event Dashboard (<?php echo $role; ?>)</h2>

<?php if ($role == 'user'): ?>
<p><a href="myevents.php">My Events</a></p>
<?php endif; ?>

<?php if ($role == 'manager'): ?>
<h3>Add Event</h3>

<form action="insert.php" method="POST" onsubmit="return validateForm()">
<input type="text" id="name" name="name" placeholder="Event Name">
<input type="text" id="location" name="location" placeholder="Location">
<input type="date" name="event_date">
<input type="time" name="event_time">
<button>Add Event</button>
</form>
<?php endif; ?>

<h3>Event List</h3>

<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
<th>Location</th>
<th>Date</th>
<th>Time</th>

<?php if ($role == 'manager'): ?>
<th>Action</th>
<?php else: ?>
<th>Join</th>
<?php endif; ?>

</tr>

<?php foreach ($events as $row): ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['event_date']; ?></td>
<td><?php echo $row['event_time']; ?></td>

<?php if ($role == 'manager'): ?>
<td>
<a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a> |
<a href="update.php?id=<?php echo $row['id']; ?>">Update</a> |
<a href="participants.php?id=<?php echo $row['id']; ?>">View Participants</a>
</td>

<?php else: ?>

<td>
<?php
$check = $conn->prepare("SELECT * FROM registrations WHERE user_id=? AND event_id=?");
$check->execute([$user_id, $row['id']]);

if ($check->rowCount() > 0) {
    echo "<span style='color:green; font-weight:bold;'>Joined</span>";
} else {
    echo "<a href='join.php?id=".$row['id']."'>Join</a>";
}
?>
</td>

<?php endif; ?>

</tr>
<?php endforeach; ?>

</table>

<script>
function validateForm() {
    var name = document.getElementById("name").value;
    var location = document.getElementById("location").value;

    if (name === "" || location === "") {
        alert("Please fill all fields");
        return false;
    }
    return true;
}
</script>
</body>
</html>