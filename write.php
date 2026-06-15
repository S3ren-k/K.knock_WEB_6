<?php
	include 'db.php';
	if($_SERVER['REQUEST_METHOD'] === 'POST') {

		$title = trim($_POST['title']);
		$content = trim($_POST['content']);

		if(empty($title) || empty($content)) {
			echo "empty title & content are not allowed";
		} else {
			$sql = "INSERT INTO posts (title, content, author_id) VALUES ('$title', '$content', '$_SESSION[id]')";
			$conn->query($sql);
			$post_id = $conn->insert_id;

			if(!empty($_FILES['file']['name'])) {
                        	$original_name = $_FILES['file']['name'];
                        	$stored_path = 'uploads/' . uniqid() . '_' . $original_name;
                        	$size_bytes = $_FILES['file']['size'];

                        	if(move_uploaded_file($_FILES['file']['tmp_name'], $stored_path)) {
                                	$orig = $conn->real_escape_string($original_name);
                                	$path = $conn->real_escape_string($stored_path);
                                	$conn->query("INSERT INTO attachments (post_id, original_name, stored_path, size_bytes) VALUES ($post_id, '$orig', '$path', $size_bytes)");
                        	}
                	}
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
	<form method="POST" action="write.php" enctype="multipart/form-data">
	<table class="writing">
	<tr>
		<th width="50">Title</th>
		<td><input type="text" name="title" placeholder="write a title" required></td>
	</tr>
	<tr>
		<th>Content</th>
		<td><textarea name="content" rows="5" cols="40" placeholder="write some ideas" required></textarea></td>
	</tr>
	<tr>
		<th>File</th>
		<td><input type="file" name="file"></td>
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
