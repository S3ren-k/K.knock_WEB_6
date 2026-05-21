<?php
include 'db.php';
if (isset($_SESSION['id']) === false) {
	header('location: login.php');
	exit;
}
$comment_id = $_GET['id'];
$post_id = $_GET['post_id'];
$conn->query("DELETE FROM comments WHERE id = $comment_id AND author_id = " . $_SESSION['id']);
?>
<script type="text/javascript">
alert("The comment is deleted!");
location.href = 'view.php?id=<?php echo $post_id; ?>';
</script>
