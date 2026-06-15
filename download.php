<?php
include 'db.php';
$id = $_GET['id'];
$file = $conn->query("SELECT * FROM attachments WHERE id = $id")->fetch_array();

if(!$file || !file_exists($file['stored_path'])) { echo "There is no file"; exit; }

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file['original_name'] . '"');
header('Content-Length: ' . filesize($file['stored_path']));
readfile($file['stored_path']);
exit;
?>
