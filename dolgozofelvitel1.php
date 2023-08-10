<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Dolgozó felvitel</title>
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
    <h1>DOLGOZÓ FELVITELE AZ ADATBÁZISBA</h1>

    <div>
        <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Személyi szám: </label>
            <input placeholder="123456AB" type="text" name="d_szigszam" required>
            <br>
            <label class="fontos">Név: </label>
            <input type="text" name="d_nev" required>
            <br>
            <label class="fontos">Nem: </label>
            <select id="nem" name="d_nem" required>
                <option value="L" selected>Nő</option>
                <option value="F" >Férfi</option>
            </select>
            <br>
            <label class="fontos">Születési dátum: </label>
            <input type="date" name="d_szul_datum" required>
            <br>
            <label class="fontos">Menhely neve: </label>
            <select name="d_menhely_nev" required>
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

