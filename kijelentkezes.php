<?php

session_start();

// ha az admin nincs bejelentkezve, akkor atiranyitjuk a bejelentkezes oldalra

if (!isset($_SESSION["user"])) {
    header("Location: admin.php");
}

// kijelentkezes
session_unset();
session_destroy();

header("Location: admin.php");

