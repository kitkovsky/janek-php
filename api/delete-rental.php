<?php
include("../db/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM wypozyczenia WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../pages/rentals.php?deleted=1");
        exit();
    } else {
        header("Location: ../pages/rentals.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: ../pages/rentals.php");
    exit();
}

$conn->close();
?>
