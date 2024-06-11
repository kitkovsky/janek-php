<?php
  include("../db/connect.php");

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $imie = $_POST["imie"];
      $nazwisko = $_POST["nazwisko"];
      $mail = $_POST["mail"];
      $numer_tel = $_POST["numer_tel"];
      $adres = $_POST["adres"];

      $sql = "INSERT INTO czytelnicy (imie, nazwisko, mail, numer_tel, adres) VALUES (?, ?, ?, ?, ?)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sssss", $imie, $nazwisko, $mail, $numer_tel, $adres);

      if ($stmt->execute()) {
          header("Location: ../pages/readers.php?success=1");
          exit();
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

      $stmt->close();
  }
?>
