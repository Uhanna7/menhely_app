<?php
function menhely_csatlakozas(){
    $conn = mysqli_connect("localhost", "root", "") or die("Csatlakozási hiba");
    if (false == mysqli_select_db($conn, "menhely")) {
        return null;
    }

    // karakterkodolas beallitasa
    mysqli_query($conn, 'SET NAMES utf8');
    mysqli_query($conn, "SET character_set_results=utf8");
    mysqli_set_charset($conn, 'utf8');

    return $conn;
}

// BESZURASOK
function onkentest_beszur($szigszam, $nev, $nem, $szul_datum, $menhely_nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"INSERT INTO DOLGOZO(szigszam, nev, nem, szul_datum, menhely_nev) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $szigszam, $nev, $nem, $szul_datum, $menhely_nev);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function eledelt_beszur($marka, $tipus, $mennyiseg, $menhely_nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    //prepare = elokeszites
    $stmt = mysqli_prepare( $conn,"INSERT INTO ELEDEL(marka, tipus, mennyiseg, menhely_nev) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssds", $marka, $tipus, $mennyiseg, $menhely_nev);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function kutyat_beszur($nev, $nem, $szul_ev, $fajta, $miota, $menhely_nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"INSERT INTO KUTYA(nev, nem, szul_ev, fajta, miota, menhely_nev) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdsss", $nev, $nem, $szul_ev, $fajta, $miota, $menhely_nev);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function orokbefogadot_beszur($szigszam, $nev, $nem, $szul_datum) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"INSERT INTO OROKBEFOGADO(szigszam, nev, nem, szul_datum) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $szigszam,$nev, $nem, $szul_datum);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function menhelyet_beszur($nev, $kapacitas, $varos, $utca, $hazszam) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"INSERT INTO MENHELY(nev, kapacitas, varos, utca, hazszam) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sdssd", $nev,$kapacitas, $varos, $utca, $hazszam);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function dolgozot_beszur($szigszam, $nev, $nem, $szul_datum, $menhely_nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"INSERT INTO DOLGOZO(szigszam, nev, nem, szul_datum, onkentes, menhely_nev) VALUES (?, ?, ?, ?, false, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $szigszam, $nev, $nem, $szul_datum, $menhely_nev);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function eszi_beszur($nev, $menhely_nev, $marka, $tipus) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $elso_kezdes ="SELECT kod FROM KUTYA WHERE nev = '{$nev}'";
    $elso1 = mysqli_query($conn, $elso_kezdes) or die (mysqli_error($conn));
    $elso = mysqli_fetch_assoc($elso1);

    $masodik_kezdes = "SELECT keszlet_kod FROM ELEDEL, MENHELY WHERE ELEDEL.menhely_nev = MENHELY.nev AND menhely_nev = '{$menhely_nev}' AND marka = '{$marka}' AND tipus = '{$tipus}'";
    $masodik1 = mysqli_query($conn, $masodik_kezdes) or die (mysqli_error($conn));
    $masodik = mysqli_fetch_assoc($masodik1);

    $sql = "INSERT INTO Eszi (kutya_kod, eledel_keszlet_kod) VALUES ('{$elso["kod"]}', '{$masodik["keszlet_kod"]}')";
    $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));

    return $res;
}


// MODOSITAS
function eledelt_hozzaad($mennyiseg, $marka, $tipus, $menhely_nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $al = mysqli_prepare( $conn,"UPDATE ELEDEL SET mennyiseg = (mennyiseg + ?) WHERE keszlet_kod = (SELECT keszlet_kod FROM eledel WHERE marka = ? AND tipus = ? AND menhely_nev = ?)");
    mysqli_stmt_bind_param($al, "dsss", $mennyiseg, $marka, $tipus, $menhely_nev);

    $sikeres = mysqli_stmt_execute($al);

    mysqli_close($conn);
    return $sikeres;

}

function orokbefogadas_kutya_modositas($o_szigszam, $kod) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }
    $stmt = mysqli_prepare( $conn,"UPDATE KUTYA SET orokbefogado_szigszam = ?, mikor = CURDATE() WHERE kod = ?");

    mysqli_stmt_bind_param($stmt, "sd", $o_szigszam, $kod);

    $sikeres1 = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres1;
}

function orokbefogadas_kutya_modositas_masik($o_nev, $kod) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"UPDATE KUTYA SET orokbefogado_szigszam = (SELECT szigszam FROM Orokbefogado WHERE nev = ?), mikor = CURDATE() WHERE kod = ?");
    mysqli_stmt_bind_param($stmt, "sd", $o_nev, $kod);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function kutyat_modosit($miota, $menhely_nev, $nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE Kutya SET miota = ?, menhely_nev = ? WHERE nev = ?");
    mysqli_stmt_bind_param($sql, "sss", $miota, $menhely_nev, $nev);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}

function orokbefogadot_modosit($nev, $regi) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE Orokbefogado SET nev = ? WHERE nev = ?");
    mysqli_stmt_bind_param($sql, "ss", $nev, $regi);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}

function menhelyet_modosit($kapacitas, $nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE Menhely SET kapacitas = ? WHERE nev = ?");
    mysqli_stmt_bind_param($sql, "ds", $kapacitas, $nev);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}

function dolgozot_modosit($nev, $regi, $onkentes) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE DOLGOZO SET nev = ?, onkentes = ? WHERE nev = ?");
    mysqli_stmt_bind_param($sql, "sss", $nev, $onkentes, $regi);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}

function eledelt_modosit($mennyiseg, $menhely_nev, $marka, $tipus) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE ELEDEL SET mennyiseg = ? WHERE menhely_nev = ? AND marka = ? AND tipus = ?");
    mysqli_stmt_bind_param($sql, "dsss", $mennyiseg, $menhely_nev, $marka, $tipus);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}


// TORLES
function kutya_torles($nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"DELETE FROM ESZI WHERE kutya_kod = (SELECT kod FROM KUTYA WHERE nev = ?)");
    mysqli_stmt_bind_param($sql, "s", $nev);

    $stmt = mysqli_prepare( $conn,"DELETE FROM KUTYA WHERE nev = ?");
    mysqli_stmt_bind_param($stmt, "s", $nev);

    $sikeres1 = mysqli_stmt_execute($sql);
    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres && $sikeres1;
}

//kutyanevet kap parameterben
function orokbefogadas_torles($nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"UPDATE KUTYA SET mikor = NULL, orokbefogado_szigszam = NULL WHERE nev = ?");
    mysqli_stmt_bind_param($sql, "s", $nev);

    $sikeres = mysqli_stmt_execute($sql);

    mysqli_close($conn);
    return $sikeres;
}

function orokbefogado_torles($szigszam) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_query($conn, "SELECT COUNT(kod) AS eredmeny FROM Kutya WHERE orokbefogado_szigszam = '{$szigszam}'");
    $current_row = mysqli_fetch_row($sql);
    if ($current_row[0] == 0) {
        $torles = mysqli_prepare($conn, "DELETE FROM OROKBEFOGADO WHERE szigszam = ?");
        mysqli_stmt_bind_param($torles, "s", $szigszam);

        $sikeres = mysqli_stmt_execute($torles);
    }else if ($current_row[0]  >= 1) {
        header("Location: hiba.php");
    }

    mysqli_close($conn);
    return $sikeres;
}

function dolgozo_torles($szigszam) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $stmt = mysqli_prepare( $conn,"DELETE FROM DOLGOZO WHERE szigszam = ?");
    mysqli_stmt_bind_param($stmt, "s", $szigszam);

    $sikeres = mysqli_stmt_execute($stmt);

    mysqli_close($conn);
    return $sikeres;
}

function menhely_torles($nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_query($conn, "SELECT COUNT(kod) AS eredmeny FROM Kutya WHERE menhely_nev = '{$nev}'");
    $current_row = mysqli_fetch_row($sql);

    $sql1 = mysqli_query($conn, "SELECT COUNT(szigszam) AS eredmeny FROM Dolgozo WHERE menhely_nev = '{$nev}'");
    $current_row1 = mysqli_fetch_row($sql1);


    if ($current_row[0] == 0 && $current_row1[0] == 0) {
        $torles = mysqli_prepare($conn, "DELETE FROM MENHELY WHERE nev = ?");
        mysqli_stmt_bind_param($torles, "s", $nev);

        $sikeres = mysqli_stmt_execute($torles);
    }else {
        header("Location: hiba.php");
    }

    mysqli_close($conn);
    return $sikeres;
}



// LISTA
function kutya_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT nev, nem, szul_ev, fajta, menhely_nev FROM KUTYA");

    mysqli_close($conn);
    return $result;
}

function orokbefogado_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT szigszam, nev, nem, szul_datum FROM OROKBEFOGADO");

    mysqli_close($conn);
    return $result;
}

function orokbefogadasok_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT Orokbefogado.nev AS o_nev, Kutya.nev FROM OROKBEFOGADO, KUTYA WHERE Kutya.orokbefogado_szigszam = Orokbefogado.szigszam");

    mysqli_close($conn);
    return $result;
}

function orokbefogadasok2_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT Orokbefogado.nev AS o_nev, Kutya.nev, Kutya.mikor FROM OROKBEFOGADO, KUTYA WHERE Kutya.orokbefogado_szigszam = Orokbefogado.szigszam");

    mysqli_close($conn);
    return $result;
}

function menhely_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT nev, kapacitas, varos, utca, hazszam FROM MENHELY");

    mysqli_close($conn);
    return $result;
}

function dolgozo_lista() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT szigszam, nev, nem, szul_datum, onkentes, menhely_nev FROM DOLGOZO");

    mysqli_close($conn);
    return $result;
}



// EGYEB
function kivalasztott_menhely($nev) {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $sql = mysqli_prepare( $conn,"SELECT KUTYA.nev FROM KUTYA WHERE KUTYA.menhely_nev = ? AND KUTYA.mikor IS NULL"); // nullra allitja a kodot, ott ahol a nev ?
    mysqli_stmt_bind_param($sql, "s", $nev);

    $sikeres = mysqli_stmt_execute($sql);


    mysqli_close($conn);
    return $sikeres;
}

function van_e() {
    if ( !($conn = menhely_csatlakozas()) ) {
        return false;
    }

    $result = mysqli_query( $conn,"SELECT nev FROM KUTYA");

    mysqli_close($conn);
    return $result;
}







