<?php
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = $_POST['id'];

	// Query untuk menghapus artikel berdasarkan ID
	$sql = "DELETE FROM artikel WHERE id_artikel='$id'";

	if ($conn->query($sql) === TRUE) {
		echo "Artikel berhasil dihapus.";
	} else {
		echo "Error: " . $conn->error;
	}

	$conn->close();
} else {
	echo "Permintaan tidak valid.";
}
?>
