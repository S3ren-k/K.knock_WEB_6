<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Board</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php
		$id = $_GET['id'];
		$sql = $conn->query("SELECT * FROM posts WHERE id = $id");
		$board = $sql->fetch_array();
	?>
	<div class="view">
		<h2><?php echo $board['title']; ?></h2>
		<div class="user_info">
		<p><b>Author </b>
			<?php
			$user_sql = $conn->query("SELECT username FROM users WHERE id = " . $board['author_id']);
			$user_data = $user_sql->fetch_array();
			$user_name = $user_data['username'];
			echo $user_name; ?> | <?php echo $board['created_at']; ?> </p>
		</div>
		<hr>
		<div class="content">
			<?php echo nl2br($board['content']); ?>
		</div>
		<div class="viewButton">
			<ul>
				<li><button onclick="location.href='index.php'">List</button></li>
				<?php
					if($board['author_id'] == $_SESSION['id']) { ?>
				<li><button onclick="location.href='modify.php?id=<?= $board['id']; ?>'">Modify</button></li>
				<li><button onclick="location.href='delete.php?id=<?php echo $board['id']; ?>'">Delete</button></li>
				<?php } ?>
			</ul>
		</div>
		<div style="clear:both;"></div>
		<hr>
		<div class="comments">
			<h3>Comments</h3>
			<?php
			$comment_sql = $conn->query("SELECT comments.*, users.username FROM comments JOIN users ON comments.author_id = users.id
						     WHERE comments.post_id = $id ORDER BY comments.created_at ASC");
			while ($comment = $comment_sql->fetch_array()) {
			?>
			<div class="comment">
				<p><b><?php echo $comment['username']; ?></b> | <?php echo $comment['created_at'] ?></p>
				<p><?php echo nl2br($comment['content']); ?></p>
				<?php if (isset($_SESSION['id']) && $comment['author_id'] == $_SESSION['id']) { ?>
				<button onclick="location.href='delete_comment.php?id=<?php echo $comment['id']; ?>&post_id=<?php echo $id; ?>'">Delete</button>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php if(isset($_SESSION['id'])) { ?>
		<div class="comment_form">
			<form action="add_comment.php" method="post">
				<input type="hidden" name="post_id" value="<?php echo $id; ?>">
				<textarea name="content" rows="3" placeholder="write a comment..."></textarea>
				<button type="submit">Submit</button>
			</form>
		</div>
		<?php } else { ?>
		<p><a href="login.php">Login</a>to write a comment.</p>
		<?php } ?>
	</div>
</body>
</html>
