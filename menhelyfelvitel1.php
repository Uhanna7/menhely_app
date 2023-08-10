<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Örökbefogadó felvitel</title>
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
    <h1>MENHELY FELVITELE AZ ADATBÁZISBA</h1>

    <div>
        <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Név: </label>
            <input type="text" name="m_nev" required>
            <br>
            <label class="fontos">Kapacitás: </label>
            <input type="text" name="m_kapacitas" required>
            <br>
            <label class="fontos">Város: </label>
            <input type="text" name="m_varos" required>
            <label class="fontos">Utca: </label>
            <input type="text" name="m_utca" required>
            <br>
            <label class="fontos">Házszám: </label>
            <input type="text" name="m_hazszam" required>
            <br>
            <input type="submit" value="Küldés" />
            <a href="adminf.php" class="vissza">VISSZA</a>
        </form>
    </div>

</main>
</body>
</html>
