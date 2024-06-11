<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Biblioteka | Wypozyczenia</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
  include("../db/connect.php");
  include("../components/header.php");

  if (isset($_GET['success']) && $_GET['success'] == 1) {
      echo "<p style='color: green;'>Nowe wypozyczenie dodane poprawnie.</p>";
  }

  if (isset($_GET['returned']) && $_GET['returned'] == 1) {
      echo "<p style='color: green;'>Wypozyczenie zakonczone poprawnie.</p>";
  }

  if (isset($_GET['edited']) && $_GET['edited'] == 1) {
      echo "<p style='color: green;'>Dane wypozyczenia zostaly zaktualizowane.</p>";
  }

  if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
      echo "<p style='color: green;'>Wypozyczenie usuniete poprawnie.</p>";
  }

  echo("<h2>Wypozyczenia</h2>");

  $sql = "SELECT * FROM wypozyczenia";
  $result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $work_sql = "SELECT nazwa FROM dziela WHERE id = " . $row["dzielo_id"];
        $work_result = $conn->query($work_sql);
        $work_title = "";

        if ($work_result->num_rows > 0) {
            $work_row = $work_result->fetch_assoc();
            $work_title = $work_row["nazwa"];
        }

        $reader_sql = "SELECT imie, nazwisko FROM czytelnicy WHERE id = " . $row["czytelnik_id"];
        $reader_result = $conn->query($reader_sql);
        $reader_name = "";

        if ($reader_result->num_rows > 0) {
            $reader_row = $reader_result->fetch_assoc();
            $reader_name = $reader_row["imie"] . " " . $reader_row["nazwisko"];
        }

        echo $row["id"] . " | " . $reader_name . " |  " . $work_title . " | Data wypozyczenia: " . $row["data_wypozyczenia"] . " | Data zwrotu: " . $row["data_zwrotu"];

        if(empty($row["data_zwrotu"])) {
            echo " <form style='display:inline;' action='../api/mark-rental-complete.php' method='post'>
                      <input type='hidden' name='id' value='" . $row["id"] . "'>
                      <button type='submit'>Oznacz jako zwrocone</button>
                   </form>";
        }

        echo " <form style='display:inline;' action='../pages/edit-rental.php' method='get'>
                  <input type='hidden' name='id' value='" . $row["id"] . "'>
                  <button type='submit'>Edytuj</button>
               </form>";

        echo " <form style='display:inline;' action='../api/delete-rental.php' method='post'>
                  <input type='hidden' name='id' value='" . $row["id"] . "'>
                  <button type='submit'>x</button>
               </form><br>";
      }
  } else {
      echo "brak wypozyczen";
  }

  $sql_czytelnicy = "SELECT id, imie, nazwisko FROM czytelnicy";
  $result_czytelnicy = $conn->query($sql_czytelnicy);

  $sql_dziela = "SELECT id, nazwa FROM dziela";
  $result_dziela = $conn->query($sql_dziela);

  $conn->close();
?>

<h2>Dodaj wypozyczenie</h2>
<form action="../api/add-rental.php" method="post">
  <label for="czytelnik_id">Czytelnik:</label>
  <select id="czytelnik_id" name="czytelnik_id" required>
    <?php
      if ($result_czytelnicy->num_rows > 0) {
          while($row_czytelnicy = $result_czytelnicy->fetch_assoc()) {
              echo "<option value='" . $row_czytelnicy["id"] . "'>" . $row_czytelnicy["imie"] . " " . $row_czytelnicy["nazwisko"] . "</option>";
          }
      } else {
          echo "<option value=''>Brak czytelnikow</option>";
      }
    ?>
  </select><br>

  <label for="dzielo_id">Dzielo:</label>
  <select id="dzielo_id" name="dzielo_id" required>
    <?php
      if ($result_dziela->num_rows > 0) {
          while($row_dziela = $result_dziela->fetch_assoc()) {
              echo "<option value='" . $row_dziela["id"] . "'>" . $row_dziela["nazwa"] . "</option>";
          }
      } else {
          echo "<option value=''>Brak dziel</option>";
      }
    ?>
  </select><br>

  <label for="data_wypozyczenia">Data wypozyczenia:</label>
  <input type="date" id="data_wypozyczenia" name="data_wypozyczenia" required><br>

  <button type="submit">Dodaj wypozyczenie</button>
</form>

</body>
</html>
