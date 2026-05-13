<?php
session_start();
include 'db.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$user]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data && password_verify($pass, $data['password'])) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['role'] = $data['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Login</h2>

<?php if ($error != ""): ?>
<p style="color:red; text-align:center; margin:10px 0;">
    <?php echo $error; ?>
</p>
<?php endif; ?>
<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button>Login</button>
</form>
<p style="text-align:center; margin-top:10px;">
    New user? <a href="register.php">Register here</a>
</p>
</body>
</html>