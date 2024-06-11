<?php
include("../db/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $mail = $_POST['mail'];
    $numer_tel = $_POST['numer_tel'];
    $adres = $_POST['adres'];

    $sql = "UPDATE czytelnicy SET imie = ?, nazwisko = ?, mail = ?, numer_tel = ?, adres = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $imie, $nazwisko, $mail, $numer_tel, $adres, $id);

    if ($stmt->execute()) {
        header("Location: ../pages/readers.php?id=$id&edited=1");
        exit();
    } else {
        echo "Blad przy edycji czytelnika" . $conn->error;
    }

    $stmt->close();
} else {
    echo "Nieprawidlowe danie.";
}

$conn->close();
?>
