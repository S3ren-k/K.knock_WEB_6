<?php
require_once('db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = isset($_POST['username']) ? $_POST['username'] : null;
	$pw = isset($_POST['password']) ? $_POST['password'] : null;

	if($name == null || $pw == null) {
		echo "<script>alert('Please fill the name & password'); location.href='login.php';</script>";
		exit();
	}
	$result = $conn->query("SELECT * FROM users WHERE username = '$name'");
        $user = $result->fetch_array();

        if (!$user) {
        	echo "<script>alert('Name & Password are not correct'); location.href='login.php';</script>";
        	exit();
    	}


    	$is_match_pw = password_verify($pw, $user['password']);

    	if ($is_match_pw) {
        	$_SESSION['id'] = $user['id'];
        	$_SESSION['username'] = $user['username'];
        	echo "<script>alert('Logged in successfully'); location.href='index.php';</script>";
    	} else {
        	echo "<script>alert('Name & Password are not correct'); location.href='login.php';</script>";
    	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <table>
                <tr>
                    <td style="text-align:right; font-weight:bolder;">Name</td>
                    <td style="text-align:left;"><input type="text" name="username" required placeholder="name" size="40"></td>
                </tr>
                <tr>
                    <td style="text-align:right; font-weight:bolder;">Password</td>
                    <td style="text-align:left;"><input type="password" name="password" required placeholder="password" size="40"></td>
                </tr>
                <tr class="loginSubmit">
                    <td colspan="2"><input type="submit" value="Login"></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 15px;">Not registered yet? <a href="register.php">Register</a></td>
                </tr>
	    </table>
        </form>
    </div>
</body>
</html>

