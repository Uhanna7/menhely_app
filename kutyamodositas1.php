<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kutya módosítás</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.jpg">
    <link rel="stylesheet" href="menhely.css">
</head>
<body>
<?php
include_once "common/header.php";
include_once "common/fuggvenyek.php";
include_once "common/db_fuggvenyek.php";
navigacioGeneralasa("admin");

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}
?>

<main>
    <h1>KUTYA MÓDOSÍTÁSA</h1>

    <div>
        <form method="POST" action="modositas.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Kutya : </label>
            <select name="k_nev" required>
                <?php
                $sql = "SELECT nev FROM Kutya WHERE mikor IS NULL";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                }
                ?>
            </select>
            <br>
            <label class="fontos">Másik menhelyre kerülés dátuma: </label>
            <input type="date" name="k_miota" required>
            <br>
            <label class="fontos">Másik menhely neve: </label>
            <select name="k_menhely_nev" required>
                <?php
                $sql = "SELECT nev FROM Menhely";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                }
                ?>
            </select>
            <br>
            <input type="submit" value="Küldés" />
            <a href="adminf.php" class="vissza">VISSZA</a>
        </form>
    </div>

</main>
</body>
</html>

