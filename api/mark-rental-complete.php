<?php
include("../db/connect.php");

if(isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "UPDATE wypozyczenia SET data_zwrotu = CURDATE() WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        header("Location: ../pages/rentals.php?returned=1");
        exit();
    } else {
        echo "Blad przy oznaczaniu jako zwrocone:" . $conn->error;
    }

    $stmt->close();
} else {
    header("Location: ../pages/rentals.php");
    exit();
}

$conn->close();
?>
