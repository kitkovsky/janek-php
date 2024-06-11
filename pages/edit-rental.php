<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edytuj wypozyczenie</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
    include("../components/header.php");
    include("../db/connect.php");

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        $sql_rental = "SELECT w.id, c.id AS czytelnik_id, c.imie AS czytelnik_imie, c.nazwisko AS czytelnik_nazwisko, d.id AS dzielo_id, d.nazwa AS dzielo_nazwa, w.data_wypozyczenia, w.data_zwrotu
                        FROM wypozyczenia w
                        INNER JOIN czytelnicy c ON w.czytelnik_id = c.id
                        INNER JOIN dziela d ON w.dzielo_id = d.id
                        WHERE w.id = ?";
        $stmt_rental = $conn->prepare($sql_rental);
        $stmt_rental->bind_param("i", $id);

        $stmt_rental->execute();

        $result_rental = $stmt_rental->get_result();

        if($result_rental->num_rows == 1) {
            $row_rental = $result_rental->fetch_assoc();

            $sql_czytelnik = "SELECT id, CONCAT(imie, ' ', nazwisko) AS full_name FROM czytelnicy";
            $result_czytelnik = $conn->query($sql_czytelnik);

            $sql_dzielo = "SELECT id, nazwa FROM dziela";
            $result_dzielo = $conn->query($sql_dzielo);
            ?>
            <h2>Edytuj wypozyczenie</h2>
            <form action="../api/update-rental.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row_rental['id']; ?>">
                <label for="czytelnik_id">Czytelnik:</label>
                <select id="czytelnik_id" name="czytelnik_id" required>
                    <?php
                    while($row_czytelnik = $result_czytelnik->fetch_assoc()) {
                        $selected = ($row_czytelnik['id'] == $row_rental['czytelnik_id']) ? 'selected' : '';
                        echo "<option value='" . $row_czytelnik['id'] . "' $selected>" . $row_czytelnik['full_name'] . "</option>";
                    }
                    ?>
                </select><br>

                <label for="dzielo_id">Dzielo:</label>
                <select id="dzielo_id" name="dzielo_id" required>
                    <?php
                    while($row_dzielo = $result_dzielo->fetch_assoc()) {
                        $selected = ($row_dzielo['id'] == $row_rental['dzielo_id']) ? 'selected' : '';
                        echo "<option value='" . $row_dzielo['id'] . "' $selected>" . $row_dzielo['nazwa'] . "</option>";
                    }
                    ?>
                </select><br>

                <label for="data_wypozyczenia">Data wypozyczenia:</label>
                <input type="date" id="data_wypozyczenia" name="data_wypozyczenia" value="<?php echo $row_rental['data_wypozyczenia']; ?>" required><br>

                <label for="data_zwrotu">Data zwrotu:</label>
                <input type="date" id="data_zwrotu" name="data_zwrotu" value="<?php echo $row_rental['data_zwrotu']; ?>"><br>

                <button type="submit">Edytuj wypozyczenie</button>
            </form>
            <?php
        } else {
            echo "Wypozyczenie nie znalezione.";
        }
        $stmt_rental->close();
    } else {
        echo "Brakuje ID wypozyczenia.";
    }
    $conn->close();
    ?>
</body>
</html>
