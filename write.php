<?php
	include 'db.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST') {

		$title = $_POST['title'];
		$content = $_POST['content'];

	
		if(empty($title) || empty($content)) {
			echo "empty title & content are not allowed";
		} else {
			$sql = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', '$_SESSION[id]')";
			$conn->query($sql);
			header("Location: index.php");
			exit();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="/text/css" href="style.css">
	<title>Write Your Idea</title>
</head>
<body>
	<div class="write">
	<h1>write something</h1>
	<hr/>
	<form method="POST" action="write.php">
	<table class="writing">
	<tr>
		<th width="50">Title</th>
		<td><input type="text" name="title" placeholder="write a title" required></td>
	</tr>
	<tr>
		<th>Content</th>
		<td><textarea name="content" rows="5" cols="40" placeholder="write some ideas" required></textarea></td>
	</tr>
	</table>
	<ul>
		<li><button type="button" onclick="location.href='index.php'">Back</button></li>
		<li><input class="button" type="submit" value="Submitted!"></li>
	</ul>
	</form>
	</div>
</body>
</html>
