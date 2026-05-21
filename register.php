<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$pw = isset($_POST['password']) ? $_POST['password'] : null;
	$name = isset($_POST['username']) ? $_POST['username'] : null;

	if($pw == null || $name == null) {
		echo "<script>alert('Empty forms are not allowed. Please Check it again.'); location.href='register.php';</script>";
		exit();
	}

	$bcrypt_pw = password_hash($pw, PASSWORD_BCRYPT);

	$check = $conn->query("SELECT id FROM users WHERE username = '$name'");
	if ($check->num_rows > 0) {
    	echo "<script>alert('Username already exists'); location.href='register.php';</script>";
    	exit();
	}

	$sql =  $conn->query("INSERT INTO users (password, username) VALUES ('$bcrypt_pw', '$name')");
	if ($sql) {
		echo "<script>alert('Registered successfully!'); location.href='login.php';</script>";
	} else {
		echo "<script>alert('Please register again');</script>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Register</h1>
        <form method="post" action="register.php">
            <table>
                <tr>
                    <td style="text-align:right; font-weight:bolder;">Username</td>
                    <td style="text-align:left;"><input type="text" name="username" required placeholder="text" size="40"></td>
                </tr>
                <tr>
                    <td style="text-align:right; font-weight:bolder;">Password</td>
                    <td style="text-align:left;"><input type="password" name="password" required placeholder="password" size="40"></td>
                </tr>
                <tr class="loginSubmit">
                    <td colspan="2"><input type="submit" value="Register"></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 15px;">Already registered? <a href="login.php">Login</a></td>
                </tr>
        </form>
    </div>
</body>
</html>
