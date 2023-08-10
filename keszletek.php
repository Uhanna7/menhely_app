<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Készletek</title>
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
navigacioGeneralasa("keszletek");

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}
?>

<main>
    <section>
        <h2>Készleteink</h2>

        <p>Az adományokat bármelyik csatlakozott menhely szívesen fogadja!</p>

        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT keszlet_kod, marka, tipus, mennyiseg, menhely_nev FROM Eledel ORDER BY menhely_nev";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>MÁRKA</th>';
            echo '<th>TÍPUS</th>';
            echo '<th>MENNYISÉG</th>';
            echo '<th>MENHELY NEVE</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["marka"] . '</td>';
                echo '<td>' . $current_row["tipus"] . '</td>';
                echo '<td>' . $current_row["mennyiseg"] . '</td>';
                echo '<td>' . $current_row["menhely_nev"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }
        ?>

    </section>

    <br>

    <section>
        <h2>Mennyiségek menhelyenként márkától és típustól függetlenül: </h2>

        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT Menhely.nev, SUM(mennyiseg) AS osszes FROM MENHELY, ELEDEL WHERE Menhely.nev = Eledel.menhely_nev GROUP BY Menhely.nev";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!'); // végrehajtjuk az SQL utasítást

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>MENHELY NEVE</th>';
            echo '<th>ÖSSZES MENNYISÉG</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["osszes"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }
        ?>

    </section>

    <h2>Melyik márkájú eledelt mennyire eszik a kutyusok?</h2>
    <form action="keszletek.php"  method="GET">
        <select name="sel">
            <?php
            $sql = "SELECT marka FROM ELEDEL GROUP BY marka";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
            while ( ($egySor = mysqli_fetch_assoc($res))!= null) {
                echo '<option value="'.$egySor["marka"].'">'.$egySor["marka"].'</option>';
            }
            ?>
        </select>
        <input type="submit" name="submit">
    </form>
    <?php
    if(@isset($_GET["sel"])) {
        mysqli_select_db($conn, 'menhely') or die("Hiba: " . mysqli_error($conn));
        @$ez = $_GET["sel"];
        echo "A {$ez} márkájú eledelt kedvelő kutyák:";

        $sql = "SELECT nev FROM KUTYA INNER JOIN ESZI ON Kutya.kod = Eszi.kutya_kod WHERE KUTYA.mikor IS NULL AND Eszi.eledel_keszlet_kod IN (SELECT keszlet_kod FROM ELEDEL WHERE marka = '{$ez}')";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

        echo '<table border=1>';
        echo '<tr>';
        echo '<th>Kutyák nevei</th>';
        echo '</tr>';

        while (($current_row = mysqli_fetch_assoc($res)) != null) {
            echo '<tr>';
            echo '<td>' . $current_row["nev"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
        ?>


    <br>
    <br>
    <br>

    <h1>Mivel tudok segíteni?</h1>

<div>
    <form method="POST" action="felvitel.php" autocomplete="off" accept-charset="utf-8">
        <label class="fontos">Eledel márkája: </label>
        <input type="text" name="e_marka" required>
        <br>
        <label class="fontos">Eledel típusa: </label>
        <select id="tipus" name="e_tipus" required>
            <option value="normál" selected>Normál</option>
            <option value="junior" >Junior</option>
            <option value="allergén" >Allergén</option>
        </select>
        <br>
        <label class="fontos">Eledel mennyisége: </label>
        <input type="text" name="e_mennyiseg" required>
        <br>
        <label class="fontos">Menhely neve: </label>
        <select name="e_menhely_nev" required>
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
    </form>

</div>

</main>
</body>
</html>