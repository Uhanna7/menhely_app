<?php
// Egy függvény, amely legenerálja a navigációs menüt. A függvényhíváskor az $aktualisOldal értéke jelzi, hogy
// melyik menüpont tartozik az aktuális oldalhoz (ehhez a menüponthoz hozzárendeljük a class="active" attribútumot).

function navigacioGeneralasa(string $aktualisOldal)
{
    echo "<nav><ul>" .
        "<li" . ($aktualisOldal === "index" ? " class='active'" : "") . ">" .
        "<a href='index.php'>Főoldal</a>" .
        "</li>" .
        "<li" . ($aktualisOldal === "kutya" ? " class='active'" : "") . ">" .
        "<a href='kutya.php'>Kutyák</a>" .
        "</li>" .
        "<li" . ($aktualisOldal === "orokbefogadok" ? " class='active'" : "") . ">" .
        "<a href='orokbefogadok_kezdes.php'>Örökbefogadás</a>" .
        "</li>" .
        "<li" . ($aktualisOldal === "keszletek" ? " class='active'" : "") . ">" .
        "<a href='keszletek.php'>Készletek</a>" .
        "</li>" .
        "<li" . ($aktualisOldal === "admin" ? " class='active'" : "") . ">" .
        "<a href='admin.php'>Admin</a>" .
        "</li>" .
        "</ul></nav>";
}

// Egy függvény, amely a második paraméterben kapott adattömb elemeit szerializálja és elmenti az első paraméterben
// kapott elérési útvonalon található fájlba.

function adatokMentese(string $fajlnev, array $adatok) {
    $file = fopen($fajlnev, "w");

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    foreach ($adatok as $adat) {
        fwrite($file, serialize($adat) . "\n");
    }

    fclose($file);
}

// Egy függvény, amely a paraméterben kapott elérési útvonalon található fájlból beolvassa az adatokat.
// A függvény visszatérési értéke egy tömb, ami a PHP értékké alakított (más szóval deszerializált) adatokat tárolja.

function adatokBetoltese(string $fajlnev): array {
    $file = fopen($fajlnev, "r");
    $adatok = [];

    if (!$file) {
        die("Nem sikerült a fájl megnyitása!");
    }

    while (($sor = fgets($file)) !== false) {
        $adat = unserialize($sor);
        $adatok[] = $adat;
    }

    fclose($file);
    return $adatok;
}