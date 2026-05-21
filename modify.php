<?php
include 'db.php';
$id = $_GET['id'];
$sql = $conn->query("SELECT * FROM posts WHERE id = $id");
$board = $sql->fetch_array();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['title'];
	$content = $_POST['content'];
	if(empty($title) || empty($content)) {
		echo "fill the title & content";
	} else {
		$modify = "UPDATE posts SET title = '$title', content = '$content' WHERE id = $id";
		$conn->query($modify);
		header("Location: view.php?id=$id");
		exit();
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Board</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="write">
		<h1>Modify Your Idea</h1>
		<hr/>
		<form method="POST" action="modify.php?id=<?php echo $board['id']; ?>">
		<table calss="writing">
			<tr>
				<th width="50">Title</th>
				<td><input type="text" name="title" value="<?php echo $board['title']; ?>" required></td>
			</tr>
			<tr>
				<th>content</th>
				<td><textarea name="content" rows="5" cols="40" required><?php echo $board['content']; ?></textarea></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $board['id']; ?>">
		<ul>
			<li><button type="button" onclick="location.href='view.php?id=<?php echo $board['id']; ?>'">Back</button></li>
			<li><input class="button" type="submit" value="Completely Modified!"></li>
		</ul>
		</form>
	</div>
</body>
</html>



