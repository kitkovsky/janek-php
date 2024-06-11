<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Biblioteka | Czytelnicy</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
  include("../db/connect.php");
  include("../components/header.php");

  if (isset($_GET['success']) && $_GET['success'] == 1) {
      echo "<p style='color: green;'>Nowy czytelnik dodany poprawnie.</p>";
  }

  echo("<h2>Czytelnicy</h2>");

  $sql = "SELECT * FROM czytelnicy";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo $row["id"] . " | " . $row["imie"] . " " . $row["nazwisko"] . " | " . $row["mail"] . " | " . $row["numer_tel"] . " | " . $row["adres"] . "<br>";
      }
  } else {
      echo "brak czytelnikow";
  }
  $conn->close();

  echo <<<HTML
  <h2>Dodaj czytelnika</h2>
  <form action="../api/add-reader.php" method="post">
    <label for="imie">Imie:</label>
    <input type="text" id="imie" name="imie" required><br>

    <label for="nazwisko">Nazwisko</label>
    <input type="text" id="nazwisko" name="nazwisko" required><br>

    <label for="mail">Email:</label>
    <input type="email" id="mail" name="mail" required><br>

    <label for="numer_tel">Numer tel:</label>
    <input type="text" id="numer_tel" name="numer_tel" required><br>

    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" required><br>

    <button type="submit">Dodaj czytelnika</button>
  </form>
  HTML;
?>
</body>
</html>