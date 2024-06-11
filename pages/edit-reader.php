<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Biblioteka</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php
include("../components/header.php");
include("../db/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM czytelnicy WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>

<h2>Edit Reader</h2>
<form action="../api/update-reader.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label for="imie">Imie:</label>
    <input type="text" id="imie" name="imie" value="<?php echo $row['imie']; ?>" required><br>

    <label for="nazwisko">Nazwisko:</label>
    <input type="text" id="nazwisko" name="nazwisko" value="<?php echo $row['nazwisko']; ?>" required><br>

    <label for="mail">Email:</label>
    <input type="email" id="mail" name="mail" value="<?php echo $row['mail']; ?>" required><br>

    <label for="numer_tel">Numer tel:</label>
    <input type="text" id="numer_tel" name="numer_tel" value="<?php echo $row['numer_tel']; ?>" required><br>

    <label for="adres">Adres:</label>
    <input type="text" id="adres" name="adres" value="<?php echo $row['adres']; ?>" required><br>

    <button type="submit">Zapisz zmiany</button>
</form>

<?php
    } else {
        echo "Czytelnik nie zostal znaleziony.";
    }

    $stmt->close();
} else {
    echo "Nieprawidlowe dane.";
}

$conn->close();
?>
</body>
</html>
