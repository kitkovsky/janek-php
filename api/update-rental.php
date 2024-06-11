<?php
include("../db/connect.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $czytelnik_id = $_POST['czytelnik_id'];
    $dzielo_id = $_POST['dzielo_id'];
    $data_wypozyczenia = $_POST['data_wypozyczenia'];
    $data_zwrotu = $_POST['data_zwrotu'];

    $sql = "UPDATE wypozyczenia SET czytelnik_id=?, dzielo_id=?, data_wypozyczenia=?, data_zwrotu=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissi", $czytelnik_id, $dzielo_id, $data_wypozyczenia, $data_zwrotu, $id);

    if($stmt->execute()) {
        header("Location: ../pages/rentals.php?edited=1");
        exit();
    } else {
        echo "Blad przy edycji wypozyczenia: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
