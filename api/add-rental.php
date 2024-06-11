<?php
include("../db/connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $czytelnik_id = $_POST['czytelnik_id'];
    $dzielo_id = $_POST['dzielo_id'];
    $data_wypozyczenia = $_POST['data_wypozyczenia'];

    $sql = "INSERT INTO wypozyczenia (czytelnik_id, dzielo_id, data_wypozyczenia) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $czytelnik_id, $dzielo_id, $data_wypozyczenia);

    if($stmt->execute()) {
        header("Location: ../pages/rentals.php?success=1");
        exit();
    } else {
        echo "Blad przy dodawaniu wypozyczenia: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
