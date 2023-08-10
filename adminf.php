<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Admin felület</title>
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

navigacioGeneralasa("admin");

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}
?>

<main>
    <h2>KUTYÁK</h2>

    <table border="1">
        <tr>
            <th>Név</th>
            <th>Nem</th>
            <th>Születési év</th>
            <th>Fajta</th>
            <th>Menhely neve</th>
            <th></th>
        </tr>

        <?php
        $kutyak = kutya_lista();

        while( $egySor = mysqli_fetch_assoc($kutyak) ) {
            echo '<tr>';
            echo '<td>'. $egySor["nev"] .'</td>';
            echo '<td>'. $egySor["nem"] .'</td>';
            echo '<td>'. $egySor["szul_ev"] .'</td>';
            echo '<td>'. $egySor["fajta"] .'</td>';
            echo '<td>'. $egySor["menhely_nev"] .'</td>';
            echo '<td><form method="POST" action="torles.php">
				  <input type="hidden" name="toroltkutya" value="'.$egySor["nev"].'" />
				  <input type="submit" value="Kutya törlése" />
		          </form></td>';
            echo '</tr>';
        }
        mysqli_free_result($kutyak);
        ?>
    </table>

    <a href="kutyafelvitel1.php" class="egyseges">KUTYA HOZZÁADÁSA</a>
    <br>
    <br>
    <a href="kutyamodositas1.php" class="egyseges">KUTYA MÓDOSÍTÁSA</a>
    <br>
    <br>

    <h2>ÖRÖKBEFOGADÓK</h2>

    <table border="1">
        <tr>
            <th>Személyi szám</th>
            <th>Név</th>
            <th>Nem</th>
            <th>Születési dátum</th>
            <th></th>
        </tr>

        <?php
        $orokbefogadok = orokbefogado_lista();

        while( $egySor = mysqli_fetch_assoc($orokbefogadok) ) {
            echo '<tr>';
            echo '<td>'. $egySor["szigszam"] .'</td>';
            echo '<td>'. $egySor["nev"] .'</td>';
            echo '<td>'. $egySor["nem"] .'</td>';
            echo '<td>'. $egySor["szul_datum"] .'</td>';
            echo '<td><form method="POST" action="torles.php">
				  <input type="hidden" name="toroltorokbefogado" value="'.$egySor["szigszam"].'" />
				  <input type="submit" value="Örökbefogadó törlése" />
		          </form></td>';
            echo '</tr>';
        }
        mysqli_free_result($orokbefogadok);
        ?>
    </table>

    <a href="orokbefogadomodositas1.php" class="egyseges">ÖRÖKBEFOGADÓ MÓDOSÍTÁSA</a>
    <br>
    <br>

    <h2>ÖRÖKBEFOGADÁSOK</h2>

    <table border="1">
        <tr>
            <th>Örökbefogadó neve</th>
            <th>Kutya neve</th>
            <th></th>
        </tr>

        <?php

        $orokbefogadasok = orokbefogadasok_lista();

        while( $egySor = mysqli_fetch_assoc($orokbefogadasok) ) {
            echo '<tr>';
            echo '<td>'. $egySor["o_nev"] .'</td>';
            echo '<td>'. $egySor["nev"] .'</td>';
            echo '<td><form method="POST" action="torles.php">
				  <input type="hidden" name="kutyanev" value="'.$egySor["nev"].'" />
				  <input type="submit" value="Örökbefogadás törlése" />
		          </form></td>';
            echo '</tr>';
        }
        mysqli_free_result($orokbefogadasok);

        ?>
    </table>
    <br>
    <br>


    <h2>DOLGOZÓK</h2>

    <table border="1">
        <tr>
            <th>Személyi szám</th>
            <th>Név</th>
            <th>Nem</th>
            <th>Születési dátum</th>
            <th>Önkéntes</th>
            <th>Menhely neve</th>
            <th></th>
        </tr>

        <?php

        $dolgozok = dolgozo_lista();

        while( $egySor = mysqli_fetch_assoc($dolgozok) ) {
            echo '<tr>';
            echo '<td>'. $egySor["szigszam"] .'</td>';
            echo '<td>'. $egySor["nev"] .'</td>';
            echo '<td>'. $egySor["nem"] .'</td>';
            echo '<td>'. $egySor["szul_datum"] .'</td>';
            if($egySor["onkentes"] == 1) {
                echo '<td>igen</td>';
            }else {
                echo '<td>nem</td>';
            }
            echo '<td>'. $egySor["menhely_nev"] .'</td>';
            echo '<td><form method="POST" action="torles.php">
				  <input type="hidden" name="toroltdolgozo" value="'.$egySor["szigszam"].'" />
				  <input type="submit" value="Dolgozó törlése" />
		          </form></td>';
            echo '</tr>';
        }
        mysqli_free_result($dolgozok);
        ?>
    </table>

    <a href="dolgozofelvitel1.php" class="egyseges">DOLGOZÓ HOZZÁADÁSA</a>
    <br>
    <br>
    <a href="dolgozomodositas1.php" class="egyseges">DOLGOZÓ MÓDOSÍTÁSA</a>
    <br>
    <br>

    <h2>MENHELYEK</h2>

    <table border="1">
        <tr>
            <th>Név</th>
            <th>Kapacitás</th>
            <th>Város</th>
            <th>Utca</th>
            <th>Házszám</th>
            <th></th>
        </tr>

        <?php

        $menhelyek = menhely_lista();

        while( $egySor = mysqli_fetch_assoc($menhelyek) ) {
            echo '<tr>';
            echo '<td>'. $egySor["nev"] .'</td>';
            echo '<td>'. $egySor["kapacitas"] .'</td>';
            echo '<td>'. $egySor["varos"] .'</td>';
            echo '<td>'. $egySor["utca"] .'</td>';
            echo '<td>'. $egySor["hazszam"] .'</td>';
            echo '<td><form method="POST" action="torles.php">
				  <input type="hidden" name="toroltmenhely" value="'.$egySor["nev"].'" />
				  <input type="submit" value="Menhely törlése" />
		          </form></td>';
            echo '</tr>';
        }
        mysqli_free_result($menhelyek);
        ?>
    </table>

    <a href="menhelyfelvitel1.php" class="egyseges">MENHELY HOZZÁADÁSA</a>
    <br>
    <br>
    <a href="menhelymodositas1.php" class="egyseges">MENHELY MÓDOSÍTÁSA</a>
    <br>
    <br>


    <h2>KÉSZLETEK</h2>

    <table border="1">
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
    </table>

    <a href="eledelmodositas1.php" class="egyseges">ELEDEL MÓDOSÍTÁS</a>
    <br>
    <br>

    <h2>KI MIT ESZIK?</h2>

    <table border="1">
        <?php
        $sql = "SELECT Kutya.nev, Eledel.marka, Eledel.tipus FROM Kutya, Eledel, Eszi WHERE Eszi.kutya_kod = Kutya.kod AND Eszi.eledel_keszlet_kod = Eledel.keszlet_kod";
        $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

        echo '<table border=1>';
        echo '<tr>';
        echo '<th>Kutya neve</th>';
        echo '<th>Eledel márkája</th>';
        echo '<th>Eledel típusa</th>';
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
    </table>

    <form action="kijelentkezes.php" method="POST" class="logout-form">
        <input type="submit" name="logout-btn" value="Kijelentkezés">
    </form>

</main>
</body>
</html>
