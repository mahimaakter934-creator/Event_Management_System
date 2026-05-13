<?php
include 'db.php';

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $phone = $_POST['phone'];

$check = $conn->prepare("SELECT id FROM users WHERE username=?");
$check->execute([$user]);
$data = $check->fetch(PDO::FETCH_ASSOC);

if ($data) {
        $error = "Username already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users(username, password, role, phone) VALUES(?, ?, ?, ?)");
        $stmt->execute([$user, $pass, $role, $phone]);

        echo "<script>alert('Registered Successfully'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Register</h2>

<?php if ($error != ""): ?>
<p style="color:red; text-align:center;">
    <?php echo $error; ?>
</p>
<?php endif; ?>

<?php if ($message != ""): ?>
<p style="color:green; text-align:center;">
    <?php echo $message; ?>
</p>
<?php endif; ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<input type="text" name="phone" placeholder="Phone Number" required>

<select name="role">
<option value="manager">Event Manager</option>
<option value="user">User</option>
</select>

<button>Register</button>
</form>

<p style="text-align:center;">
    Already have an account? <a href="login.php">Login here</a>
</p>
</body>
</html>