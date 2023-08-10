<?php
include_once "classes/Felhasznalo.php";
include_once "common/fuggvenyek.php";
session_start();

$felhasznalok = adatokBetoltese("data/felhasznalok.txt");

$hibak = [];

// regisztráció
if (isset($_POST["signup-btn"])) {
    $felhasznalonev = $_POST["username"];
    $jelszo = $_POST["password"];
    $ellenorzoJelszo = $_POST["password2"];
    $email = $_POST["email"];
    $szuletesiEv = $_POST["year-of-birth"];
    $nem = "egyéb";
    $jelolonegyzetek = [];

    if (isset($_POST["gender"])) {
        $nem = $_POST["gender"];
    }

    if (isset($_POST["confirmations"])) {
        $jelolonegyzetek = $_POST["confirmations"];
    }


    if (trim($felhasznalonev) === "" || trim($jelszo) === "" || trim($ellenorzoJelszo) === "" ||
        trim($email) === "" || trim($szuletesiEv) === "") {
        $hibak[] = "Minden kötelezően kitöltendő mezőt ki kell tölteni!";
    }

    foreach ($felhasznalok as $felhasznalo) {
        if ($felhasznalo->getFelhasznalonev() === $felhasznalonev) {
            $hibak[] = "A felhasználónév már foglalt!";
        }
    }

    if ($felhasznalonev === "default") {
        $hibak[] = "A felhasználónév már foglalt!";
    }

    if (strlen($jelszo) < 5) {
        $hibak[] = "A jelszónak legalább 5 karakter hosszúnak kell lennie!";
    }

    if (!preg_match("/[A-Za-z]/", $jelszo) || !preg_match("/[0-9]/", $jelszo)) {
        $hibak[] = "A jelszónak tartalmaznia kell betűt és számjegyet is!";
    }

    if (!preg_match("/[0-9a-z.-]+@([0-9a-z-]+\.)+[a-z]{2,4}/", $email)) {
        $hibak[] = "A megadott e-mail cím formátuma nem megfelelő!";
    }

    if ($jelszo !== $ellenorzoJelszo) {
        $hibak[] = "A két jelszó nem egyezik!";
    }

    foreach ($felhasznalok as $felhasznalo) {
        if ($felhasznalo->getEmail() === $email) {
            $hibak[] = "Az e-mail cím már foglalt!";
        }
    }

    if (count($jelolonegyzetek) < 2) {
        $hibak[] = "Mindkét jelölőnégyzetet be kell jelölni!";
    }

    if (count($hibak) === 0) {
        $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);         // Jelszó titkosítása
        $felhasznalo = new Felhasznalo($felhasznalonev, $jelszo, $email);
        $felhasznalok[] = $felhasznalo;
        adatokMentese("data/felhasznalok.txt", $felhasznalok);    // Felhasználók fájlba való mentése
        header("Location: regiszt.php?siker=true");
    }
}
?>

    <!DOCTYPE html>
    <html lang="hu">
<head>
    <title>Regisztráció</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/icon.png">
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
    <h1 class="center">Regisztráció</h1>

    <?php
    if (isset($_GET["siker"])) {
        echo "<div class='success'><p>Sikeres regisztráció!</p></div>";
    }

    // A regisztráció során előforduló esetleges hibák kiíratása.

    if (count($hibak) > 0) {
        echo "<div class='errors'>";

        foreach ($hibak as $hiba) {
            echo "<p>" . $hiba . "</p>";
        }

        echo "</div>";
    }
    ?>

    <div class="form-container">
        <form action="regiszt.php" method="POST" autocomplete="off" enctype="multipart/form-data">
            <label for="uname" class="fontos">Felhasználónév: </label>
            <input type="text" name="username" id="uname" required
                <?php if (isset($_POST["username"])) echo "value='" . $_POST["username"] . "'" ?>>

            <label for="pswd" class="fontos">Jelszó: </label>
            <input type="password" name="password" id="pswd" required>

            <label for="pswd2" class="fontos">Jelszó ismét: </label>
            <input type="password" name="password2" id="pswd2" required>

            <label for="email" class="fontos">E-mail cím:</label>
            <input type="email" name="email" id="email" required
                <?php if (isset($_POST["email"])) echo "value='" . $_POST["email"] . "'" ?>>

            <label for="yob" class="fontos">Születési év:</label>
            <input type="number" name="year-of-birth" id="yob" required
                <?php if (isset($_POST["year-of-birth"])) echo "value='" . $_POST["year-of-birth"] . "'" ?>>

            <div class="radio-button-container">
                Nem:
                <label>
                    <input type="radio" name="gender" value="férfi"
                        <?php if (isset($_POST["gender"]) && $_POST["gender"] === "férfi") echo "checked"; ?>>
                    Férfi
                </label>
                <label>
                    <input type="radio" name="gender" value="nő"
                        <?php if (isset($_POST["gender"]) && $_POST["gender"] === "nő") echo "checked"; ?>>
                    Nő
                </label>
            </div>

            <div class="checkbox-container">
                <label class="fontos">
                    <input type="checkbox" name="confirmations[]" value="confirm-data" required>
                    Nyilatkozom, hogy a megadott adatok a valóságnak megfelelnek.
                </label>
                <label class="fontos">
                    <input type="checkbox" name="confirmations[]" value="accept-terms-and-conditions" required>
                    Elfogadom a felhasználási feltételeket.
                </label>
            </div>

            <input type="submit" name="signup-btn" value="Regisztráció">
        </form>
        <a href="admin.php" class="vissza">VISSZA</a>
    </div>
</main>

</body>
    </html><?php
