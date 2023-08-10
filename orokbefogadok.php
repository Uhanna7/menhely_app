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
    <h1>Új örökbefogadás: </h1>

    <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
        <label class="fontos">Kutya : </label>
        <select name="uj_kod" required>
            <?php
            $v_menhely_nev = $_POST['menhely_nev'];

            if(isset($v_menhely_nev)) {
                $sql = "SELECT nev, kod FROM KUTYA WHERE menhely_nev = '{$v_menhely_nev}' AND mikor IS NULL";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: ' . mysqli_error($conn));
                while (($egySor = mysqli_fetch_assoc($res)) != null) {
                    echo '<option value="' . $egySor["kod"] . '">' . $egySor["nev"] . '</option>';
                }
            }else {
                echo "sikertelen";
            }
            ?>
        </select>
        <br>
        <label><h3>Új örökbefogadó adatai: </h3></label>
        <br>
        <label class="fontos">Személyi szám: </label>
        <input placeholder="123456AB" type="text" name="uj_szigszam" required>
        <br>
        <label class="fontos">Név: </label>
        <input type="text" name="uj_nev" required>
        <br>
        <label class="fontos">Nem: </label>
        <select id="nem" name="uj_nem" required>
            <option value="n" selected>NŐ</option>
            <option value="f" >FÉRFI</option>
        </select>
        <br>
        <label class="fontos">Születési dátum: </label>
        <input type="date" name="uj_szul_datum" required>
        <br>
        <input type="submit" value="Küldés" />
        </form>


    <h1>Ha már fogadtál örökbe tőlünk:</h1>

    <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
        <label class="fontos">Kutya : </label>
        <select name="o_kod" required>
            <?php

            $v_menhely_nev = $_POST['menhely_nev'];

            if(isset($v_menhely_nev)) {
                $sql = "SELECT nev, kod FROM KUTYA WHERE menhely_nev = '{$v_menhely_nev}' AND mikor IS NULL";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: ' . mysqli_error($conn));
                while (($egySor = mysqli_fetch_assoc($res)) != null) {
                    echo '<option value="' . $egySor["kod"] . '">' . $egySor["nev"] . '</option>';
                }
            }else {
                echo "sikertelen";
            }
            ?>
        </select>
        <br>
        <label class="fontos">Örökbefogadó: </label>
        <select name="o_nev" required>
            <?php
            if ( !($conn = menhely_csatlakozas()) ) {
                return false;
            }

            $sql = "SELECT nev FROM Orokbefogado";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
            }

            ?>
        </select>
        <br>
        <input type="submit" value="Küldés" />
        <br>
        <a href="orokbefogadok_kezdes.php" class="vissza">VISSZA</a>

    </form>
</main>
</body>
</html>
