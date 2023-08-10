<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kutya felvitel</title>
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
    <h1>KUTYA FELVITELE AZ ADATBÁZISBA</h1>

    <div>
        <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
            <label class="fontos">Név: </label>
            <input type="text" name="k_nev" required>
            <br>
            <label class="fontos">Nem: </label>
            <select id="k_nem" name="k_nem" required>
                <option value="L" selected>LÁNY</option>
                <option value="F" >FIÚ</option>
            </select>
            <br>
            <label class="fontos">Születési év: </label>
            <select id="k_szul_ev" name="k_szul_ev" required>
                <option value="2022" selected>2022</option>
                <option value="2021" >2021</option>
                <option value="2020" >2020</option>
                <option value="2019" >2019</option>
                <option value="2018" >2018</option>
                <option value="2017" >2017</option>
                <option value="2016" >2016</option>
                <option value="2015" >2015</option>
                <option value="2014" >2014</option>
                <option value="2013" >2013</option>
                <option value="2012" >2012</option>
                <option value="2011" >2011</option>
                <option value="2010" >2010</option>
                <option value="2009" >2009</option>
                <option value="2008" >2008</option>
                <option value="2007" >2007</option>
            </select>
            <br>
            <label class="fontos">Fajta: </label>
            <input type="text" name="k_fajta" required>
            <br>
            <label class="fontos">Menhelyre kerülés dátuma: </label>
            <input type="date" name="k_miota" required>
            <br>
            <label class="fontos">Menhely neve: </label>
            <select name="k_menhely_nev" required>'
                <?php
                $sql = "SELECT nev FROM Menhely";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                }
                ?>
            </select>
            <br>
            <label class="fontos">Eledel márkája: </label>
            <select name="k_marka" required>'
                <?php
                $sql = "SELECT marka FROM Eledel GROUP BY marka";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<option value="'.$current_row["marka"].'">'.$current_row["marka"].'</option>';
                }
                ?>
            </select>
            <br>
            <label class="fontos">Eledel típusa: </label>
            <select id="k_tipus" name="k_tipus" required>
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
