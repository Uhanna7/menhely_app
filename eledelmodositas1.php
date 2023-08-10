<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Eledel módosítás</title>
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
    <h1>ELEDEL MÓDOSÍTÁSA</h1>

    <div>
        <form method="POST" action="modositas.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Mennyiség: </label>
            <input type="text" name="el_mennyiseg" required>
            <br>
            <label class="fontos">Menhely neve: </label>
            <select name="el_menhely_nev" required>
                <?php
                $sql = "SELECT nev FROM Menhely";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                }
                ?>
            </select>
            <label class="fontos">Márka: </label>
            <select id="marka" name="el_marka" required>
                <?php
                $sql = "SELECT DISTINCT marka FROM Eledel";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["marka"].'">'.$current_row["marka"].'</option>';
                }
                ?>
            </select>
            <label class="fontos">Típus: </label>
            <select id="tipus" name="el_tipus" required>
                <option value="normál" selected>Normál</option>
                <option value="junior" >Junior</option>
                <option value="allergén" >Allergén</option>
            </select>
            <br>
            <input type="submit" value="Küldés" />
            <a href="adminf.php" class="vissza">VISSZA</a>
        </form>
    </div>

</main>
</body>
</html>

