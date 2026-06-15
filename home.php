<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Board</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="loginButton">
	<?php
	if(isset($_SESSION) === false) { session_start(); }
	if(isset($_SESSION['id']) === false) { ?>
	<a href="login.php">Login</a>
	<a href="register.php">Register</a>
	<?php } else { ?>
	<a href="logout.php">Logout</a>
	<?php } ?>
</div>
<div class="index">
	<h1>HOME</h1>
	<h4>Choose a board</h4>
	<table>
		<tr>
			<th>No.</th>
			<th>Board</th>
			<th>Description</th>
		</tr>
		<?php
		$boards = $conn->query("SELECT * FROM boards");
		while($board = $boards->fetch_array()) {
			echo '<tr>';
			echo '<td>' . $board['id'] . '</td>';
			echo '<td><a href="index.php?board=' . $board['id'] . '">' . $board['name'] . '</a></td>';
			echo '<td>' . $board['description'] . '</td>';
			echo '</tr>';
		}
		?>
	</table>
</div>
</body>
</html>
