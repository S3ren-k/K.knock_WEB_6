<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>

<head>
<title>Board</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="loginButton">
	<?php
	if (isset($_SESSION) === false) {session_start();}
	if (isset($_SESSION['id']) === false) {
	?>
	<a href="login.php">Login</a>
	<a href="register.php">Register</a>
	<?php
	} else {
	?>
	<a href="logout.php">Logout</a>
	<?php
	}
	?>
</div>
<div class="index">
	<h1>My Notebook</h1>
	<h4>you can write whatever you want</h4>

<form method="GET" action="index.php" style="text-align:center; margin:10px 0;">
	<select name="type" style="padding:5px; font-size:14px;">
		<option value="title" <?php echo (!isset($_GET['type']) || $_GET['type'] === 'title') ? 'selected' : ''; ?>>Title</option>
		<option value="author" <?php echo (isset($_GET['type']) && $_GET['type'] === 'author') ? 'selected' : ''; ?>>Author</option>
	</select>
	<input type="text" name="search" placeholder="Search something..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding: 5px; font-size:14px;">
	<select name="order" style="padding: 5px; font-size:14px;">
		<option value="desc" <?php echo (!isset($_GET['order']) || $_GET['order'] === 'desc') ? 'selected' : ''; ?>>Newest</option>
		<option value="asc" <?php echo (isset($_GET['order']) && $_GET['order'] === 'asc') ? 'selected' : ''; ?>>Oldest</option>
	</select>
	<button type="submit" style="margin:0; padding:5px 10px;">Search</button>
</form>

	<button onclick="writePost()">new!</button>
	<table>
		<tr>
			<th width="60">No.</th>
			<th width="500">Title</th>
			<th width="120">Author</th>
			<th width="100">Date</th>
		</tr>
		<?php
			$list_num = 10;
			$page_num = 10;
			$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
			$order = (isset($_GET['order']) && $_GET['order'] === 'asc') ? 'ASC' : 'DESC';
			$type = isset($_GET['type']) ? $_GET['type'] : 'title';
			if ($search) {
				if($type === 'author') {
					$where = "JOIN users ON posts.author_id = users.id WHERE users.username LIKE '%$search%'";
				} else {
					$where = "WHERE title LIKE '%$search%'";
				}
			} else {
				$where = '';
			}
			$num = $conn->query("SELECT posts.* FROM posts $where")->num_rows;
			$page = isset($_GET['page']) ? $_GET['page'] : 1; //made pagenation(e.g. page 1, 2 ...
			$total_page = ceil($num/$page_num);
			$total_block = ceil($total_page/$page_num);
			$now_block = ceil($page/$page_num);
			$s_page = ($now_block*$page_num) - ($page_num - 1);
			if ($s_page <= 0) {
				$s_page = 1;
			}
			$e_page = $now_block * $page_num;
			if($total_page<$e_page) {
				$e_page = $total_page;
			}
			$start = ($page - 1) * $list_num;
			$sql = $conn->query("SELECT posts.* FROM posts $where ORDER BY posts.id $order LIMIT $start, $list_num");
			while ($row = $sql->fetch_array()) {
				echo '<tr>';
				echo '<td>'. $row['id']. '</td>';
				echo '<td><a href="view.php?id=' . $row['id'] . '">' . $row['title'] . '</a></td>';
				$user_sql = $conn->query("SELECT username FROM users WHERE id = " . $row['author_id']);
				$user_data = $user_sql->fetch_array();
				$user_name = $user_data['username'];
				echo '<td>' . $user_name . '</td>';
				echo '<td>' . $row['created_at'].'</td>';
				echo '</tr>';
				}
		?>
	</table>
<div class="page">
	<?php
		if($page<=1) {
			echo '<span class="fo_re">Previous</span>';
		} else {
			echo '<a href="index.php?page=1">Previous</a>';
		}

		for($print_page = $s_page; $print_page <= $e_page; $print_page++) {
			if($print_page == $page) {
				echo'<strong>' . $print_page . '</strong>';
			} else {
				echo '<a href="index.php?page=' . $print_page . '">' . $print_page . '</a>';
			}
		}

		if($page >= $total_page) {
			echo '<span class="fo_re">Next</span>';
		} else {
			echo '<a href="index.php?page='. ($page + 1) .'">Next</a>';
		}
	?>
</div>
<?php echo '<h4 class="pagenum">' . $num . ' memo in total</h4>' ?>
</div>
<script>
	function writePost() {
		<?php if(isset($_SESSION['id']) === false) { ?>
		alert('please log in or register account');
		location.href='login.php';
		<?php } else { ?>
		location.href='write.php';
		<?php } ?>
	}
</script>
</body>
</html>
