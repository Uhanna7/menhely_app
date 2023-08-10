<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kutyák</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.jpg">
    <link rel="stylesheet" href="menhely.css">
</head>
<body>
    <?php
    include_once "common/fuggvenyek.php";
    include_once "common/header.php";
    include_once "common/db_fuggvenyek.php";
    navigacioGeneralasa("kutya");

    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }
    ?>

    <main>
        <h1 class="center">KUTYUSAINK</h1>
        <img src="assets/img/orokbe.jpg" alt="Kutya" height="200">
        <br>
        <h2>Mennyire telítettek menhelyeink?</h2>
        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $osszetett = "SELECT menhely_nev, kapacitas, COUNT(kod) FROM KUTYA, MENHELY WHERE mikor IS NULL AND KUTYA.menhely_nev = MENHELY.nev GROUP BY menhely_nev";
            $res = mysqli_query($conn, $osszetett) or die ('Hibás utasítás!');

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>MENHELY</th>';
            echo '<th>KAPACITÁS</th>';
            echo '<th>JELENLEGI KUTYÁK SZÁMA</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["menhely_nev"] . '</td>';
                echo '<td>' . $current_row["kapacitas"] . '</td>';
                echo '<td>' . $current_row["COUNT(kod)"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        ?>

        <br>
        <h2>Legrégebb óta menhelyen lévő kutyus: </h2>
        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT nev, miota FROM KUTYA WHERE mikor IS NULL ORDER BY miota LIMIT 1";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>KUTYA NEVE</th>';
            echo '<th>MIÓTA</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["miota"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        ?>

        <br>
        <h2>Legtöbb kutyát örökbefogadó személy: </h2>
        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT Orokbefogado.nev, Count(kod) AS darabszam FROM Orokbefogado, Kutya WHERE Orokbefogado.szigszam = Kutya.orokbefogado_szigszam AND Kutya.mikor IS NOT NULL GROUP BY szigszam ORDER BY darabszam DESC LIMIT 1";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>ÖRÖKBEFOGADÓ NEVE</th>';
            echo '<th>ÖRÖKBEFOGADOTT KUTYÁK SZÁMA</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["darabszam"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        ?>

        <br>
        <h2>Örökbe fogadható kutyusok:</h2>

        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT nev, nem, szul_ev, fajta, mikor, miota, menhely_nev FROM Kutya WHERE mikor IS NULL ORDER BY menhely_nev";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>NÉV</th>';
            echo '<th>NEM</th>';
            echo '<th>SZÜLETÉSI ÉV</th>';
            echo '<th>FAJTA</th>';
            echo '<th>MIÓTA VAN A MENHELYEN</th>';
            echo '<th>MENHELY NÉV</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["nem"] . '</td>';
                echo '<td>' . $current_row["szul_ev"] . '</td>';
                echo '<td>' . $current_row["fajta"] . '</td>';
                echo '<td>' . $current_row["miota"] . '</td>';
                echo '<td>' . $current_row["menhely_nev"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }
        ?>
        <br>
        <br>


        <h2>Mit esznek a jelenleg menhelyen lévő kutyusaink?</h2>
        <?php
        $sql = "SELECT Kutya.nev, Eledel.marka, Eledel.tipus FROM Kutya, Eledel, Eszi WHERE Eszi.kutya_kod = Kutya.kod AND Eszi.eledel_keszlet_kod = Eledel.keszlet_kod AND Kutya.mikor IS NULL";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

        echo '<table border=1>';
            echo '<tr>';
                echo '<th>KUTYA NEVE</th>';
                echo '<th>ELEDEL MÁRKÁJA</th>';
                echo '<th>ELEDEL TÍPUSA</th>';
                echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
            echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["marka"] . '</td>';
                echo '<td>' . $current_row["tipus"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        ?>
        <br>
        <br>

        <h2>Örökbefogadások:</h2>

        <table border="1">
            <tr>
                <th>Örökbefogadó neve</th>
                <th>Kutya neve</th>
                <th>Mikor</th>
            </tr>

            <?php

            $orokbefogadasok = orokbefogadasok2_lista();

            while( $egySor = mysqli_fetch_assoc($orokbefogadasok) ) {
                echo '<tr>';
                echo '<td>'. $egySor["o_nev"] .'</td>';
                echo '<td>'. $egySor["nev"] .'</td>';
                echo '<td>'. $egySor["mikor"] .'</td>';
                echo '</tr>';
            }
            mysqli_free_result($orokbefogadasok);

            ?>
        </table>

    </main>
</body>
</html>