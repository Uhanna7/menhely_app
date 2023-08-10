<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Dolgozó módosítás</title>
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
    <h1>DOLGOZÓ MÓDOSÍTÁSA</h1>

    <div>
        <form method="POST" action="modositas.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Megváltoztatott név: </label>
            <input type="text" name="d_nev" required>
            <br>
            <label class="fontos">Régi név: </label>
            <select name="d_regi" required>
                <?php
                $sql = "SELECT nev FROM Dolgozo";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                }
                ?>
            </select>
            <br>
            <label class="fontos">Önkéntes: </label>
            <select name="d_onkentes" required>
                <option value="true">Igen</option>
                <option value="false">Nem</option>
            </select>
            <input type="submit" value="Küldés" />
            <a href="adminf.php" class="vissza">VISSZA</a>
        </form>
    </div>

</main>
</body>
</html>



