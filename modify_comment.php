<?php
include 'db.php';
if (isset($_SESSION) === false) { session_start(); }

if (!isset($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

$comment_id = $_GET['id'];
$post_id = $_GET['post_id'];

$check = $conn->query("SELECT * FROM comments WHERE id = $comment_id AND author_id = {$_SESSION['id']}");
if ($check->num_rows === 0) {
	echo "<script>alert('you cannot modify comment of other'); history.back();</script>";
	exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$content = $conn->real_escape_string($_POST['content']);
	$conn->query("UPDATE comments SET content = '$content' WHERE id = $comment_id");
	header("Location: view.php?id=$post_id");
	exit;
}

$comment = $conn->query("SELECT * FROM comments WHERE id = $comment_id")->fetch_array();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modify Your Comment</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="write">
	<h2>Modify Comment</h2>
	<form method="POST">
		<textarea name="content" style="width:90%; height:100px; margin:20px auto; display:block;"><?= htmlspecialchars($comment['content']) ?></textarea>
		<button style="margin:0; padding:5px 1px;" type="submit">Modify</button>
		<button style="margin:0; padding:5px 1px;" type="button" onclick="history.back()">Cancel</button>
	</form>
</div>
</body>
</html>
