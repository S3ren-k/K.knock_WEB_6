<?php
include 'db.php';
$id = $_GET['id'];
$sql = $conn->query("DELETE FROM posts WHERE id='$id';");
?>
<script type="text/javascript">alert("The memo is Deleted!");</script>
<meta http-equiv="refresh" content="0 url=index.php" />
