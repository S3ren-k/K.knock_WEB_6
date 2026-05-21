<?php
include 'db.php';
if (isset($_SESSION['id']) === false) {
	header('location: login.php');
	exit;
}
$post_id = $_POST['post_id'];
$content = $_POST['content'];
$author_id = $_SESSION['id'];

$conn->query("INSERT INTO comments (post_id, author_id, content) VALUES ($post_id, $author_id, '$content')");
header('location: view.php?id=' . $post_id);
?>
