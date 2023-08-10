<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Főoldal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.jpg">
    <link rel="stylesheet" href="menhely.css"/>
</head>
<body>
    <?php
    include_once "common/header.php";
    include_once "common/fuggvenyek.php";
    include_once "common/db_fuggvenyek.php";
    navigacioGeneralasa("index");

    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }
    ?>

    <main>
        <h1 class="center">Fogadj örökbe!</h1>
        <img src="assets/img/fooldal.jpg" alt="Fő" height="200">

        <section>
            <h2>Magunkról</h2>
            <p>
                Célunk, hogy az ország minél több kutyamenhelyének csatlakozásával egy olyan összegző adatbázist készítsünk,
                amely megkönnyíti az örökbefogadható kutyusok és a leendő gazdik egymásra találását.
            </p>
            <p><strong>E-mail cím:</strong> akutyakertkozosen@gmail.com</p>

            <h1>Rendszerünkben nyilvántartott menhelyek:</h1>

            <?php
            if ( mysqli_select_db($conn, 'menhely') ) {

                $sql = "SELECT nev, kapacitas, varos, utca, hazszam FROM Menhely";
                $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!');

                echo '<table border=1>';
                echo '<tr>';
                echo '<th>MENHELY NEVE</th>';
                echo '<th>KAPACITÁS (HÁNY KUTYÁT KÉPES FOGADNI)</th>';
                echo '<th>VÁROS</th>';
                echo '<th>UTCA</th>';
                echo '<th>HÁZSZÁM</th>';
                echo '</tr>';

                while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                    echo '<tr>';
                    echo '<td>' . $current_row["nev"] . '</td>';
                    echo '<td>' . $current_row["kapacitas"] . '</td>';
                    echo '<td>' . $current_row["varos"] . '</td>';
                    echo '<td>' . $current_row["utca"] . '</td>';
                    echo '<td>' . $current_row["hazszam"] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';

                mysqli_free_result($res);
            } else {
                die('Nem sikerült csatlakozni az adatbázishoz.');
            }
            ?>

        </section>


        <hr>

        <section>
            <h2 id="jelentkezes">ÖNKÉNTES JELENTKEZÉS</h2>
            <p>Jelentkezz önkéntesnek, ha szeretnél segíteni!</p>
        </section>

        <div class="urlap">
            <form action="felvitel.php" method="POST" autocomplete="off" accept-charset="utf-8">
                <label for="szigszam" class="fontos">Személyi szám: </label>
                <input placeholder="123456AB" type="text" name="on_szigszam" id="szigszam" required>
                <br>
                <label for="nev" class="fontos">Név: </label>
                <input type="text" name="on_nev" id="nev" required>
                <br>
                <label for="nev" class="fontos">Nem: </label>
                <select id="nem" name="on_nem" required>
                    <option value="f" selected>Férfi</option>
                    <option value="n">Nő</option>
                </select>
                <br>
                <label for="szul_datum" class="fontos">Születési dátum:</label>
                <input type="date" name="on_szul_datum" id="szul_datum" required>
                <br>
                <label for="menhely_nev" class="fontos">Menhely neve, ahova jelentkezik:</label>
                <select name="on_menhely_nev">'
                    <?php
                    $sql = "SELECT nev FROM Menhely";
                    $res = mysqli_query($conn, $sql) or die ('Hibás utasítás: '.mysqli_error($conn));
                    while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                        echo '<option value="'.$current_row["nev"].'">'.$current_row["nev"].'</option>';
                    }
                    ?>
                </select>
                <br>
                <input type="submit" name="kuldes-gomb" value="Küldés">
            </form>
        </div>

        <br>
        <br>

        <section>
            <h2>Dolgozóink</h2>
        </section>

        <?php
        if ( mysqli_select_db($conn, 'menhely') ) {

            $sql = "SELECT szigszam, nev, nem, szul_datum, onkentes, menhely_nev FROM Dolgozo ORDER BY menhely_nev";
            $res = mysqli_query($conn, $sql) or die ('Hibás utasítás!'); // végrehajtjuk az SQL utasítást

            echo '<table border=1>';
            echo '<tr>';
            echo '<th>NÉV</th>';
            echo '<th>NEM</th>';
            echo '<th>ÖNKÉNTES</th>';
            echo '<th>MENHELY NEVE</th>';
            echo '</tr>';

            while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
                echo '<tr>';
                echo '<td>' . $current_row["nev"] . '</td>';
                echo '<td>' . $current_row["nem"] . '</td>';
                if($current_row["onkentes"] == 1) {
                    echo '<td>igen</td>';
                }else {
                    echo '<td>nem</td>';
                }
                echo '<td>' . $current_row["menhely_nev"] . '</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);
        } else {
            die('Nem sikerült csatlakozni az adatbázishoz.');
        }

        // lezárjuk az adatbázis-kapcsolatot
        mysqli_close($conn);
        ?>
    </main>

</body>
</html>