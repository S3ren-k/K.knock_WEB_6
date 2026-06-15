<?php
include 'db.php';
$id = $_GET['id'];
$post = $conn->query("SELECT board_id FROM posts WHERE id = $id")->fetch_array();
$board_id = $post['board_id'];
$sql = $conn->query("DELETE FROM posts WHERE id='$id';");
?>
<script type="text/javascript">alert("The memo is Deleted!");</script>
<meta http-equiv="refresh" content="0; url=index.php?board=<?php echo $board_id; ?>" />
