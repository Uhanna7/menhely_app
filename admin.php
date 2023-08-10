<?php
include_once "classes/Felhasznalo.php";
include_once "common/fuggvenyek.php";
session_start();

// regisztralt felhasznalok betoltese egy tombbe
$felhasznalok = adatokBetoltese("data/felhasznalok.txt");

$sikeresBejelentkezes = true;


if (isset($_POST["login-btn"])) {
    $felhasznalonev = $_POST["username"];
    $jelszo = $_POST["password"];

    foreach ($felhasznalok as $felhasznalo) {
        // password_verify(): szoveges jelszo es hashelt jelszo osszehasonlitas

        if ($felhasznalo->getFelhasznalonev() === $felhasznalonev && password_verify($jelszo, $felhasznalo->getJelszo())) {
            $_SESSION["user"] = $felhasznalo;
            header("Location: adminf.php");
        }
    }

    $sikeresBejelentkezes = false;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Admin bejelentkezés</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.jpg">
    <link rel="stylesheet" href="menhely.css">
</head>
<body>
<?php
include_once "common/header.php";
navigacioGeneralasa("admin");
?>

<main>
    <h1 class="center">Bejelentkezés</h1>

    <?php
    // hibauzenet, ha sikertelen a bejelentkezes

    if (!$sikeresBejelentkezes) {
        echo "<div class='errors'><p>A belépési adatok nem megfelelők!</p></div>";
    }
    ?>

    <div class="form-container">
        <form action="admin.php" method="POST" autocomplete="off">
            <label for="uname" class="required-label">Felhasználónév: </label>
            <input type="text" name="username" id="uname" required>

            <label for="pswd" class="required-label">Jelszó: </label>
            <input type="password" name="password" id="pswd" required>

            <input type="submit" name="login-btn" value="Bejelentkezés">
        </form>
        <a href="regiszt.php">REGISZTRÁCIÓ</a>
    </div>
</main>
</body>
</html>
