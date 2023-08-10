<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Örökbefogadók</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.jpg">
    <link rel="stylesheet" href="menhely.css">
</head>
<body>
<?php
include_once "common/fuggvenyek.php";
include_once "common/db_fuggvenyek.php";
include_once "common/header.php";
navigacioGeneralasa("orokbefogadok");

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}
?>

<main>
    <h1>Menhely kiválasztása: </h1>
    <form method="POST" action="orokbefogadok.php" autocomplete="off" accept-charset="utf-8">
        <label>Menhely neve: </label>
        <select name="menhely_nev">
            <?php
            if ( mysqli_select_db($conn, 'menhely') ) {

                $sql = "SELECT nev FROM Menhely";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: ' . mysqli_error($conn));
                while (($current_row = mysqli_fetch_assoc($res)) != null) {
                    echo '<option value="' . $current_row["nev"] . '">' . $current_row["nev"] . '</option>';
                }
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Kiválaszt"/>
    </form>
</main>
</body>
</html>