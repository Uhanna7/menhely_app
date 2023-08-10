<?php
include_once('common/db_fuggvenyek.php');

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}


// DOLGOZO
$d_nev = $_POST['d_nev'];
$d_regi = $_POST['d_regi'];
$d_onkentes = $_POST['d_onkentes'];

if ( isset($d_nev) && isset($d_regi) && isset($d_onkentes)) {

    $sikeres = dolgozot_modosit($d_nev, $d_regi, $d_onkentes);

    if ($sikeres) {
        header('Location: adminf.php');
    } else {
        echo "Hiba volt a beszúrásnál";
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// KUTYA
$k_miota = $_POST['k_miota'];
$k_menhely_nev = $_POST['k_menhely_nev'];
$k_nev = $_POST['k_nev'];

if ( isset($k_miota) && isset($k_menhely_nev) && isset($k_nev)) {

    $sikeres = kutyat_modosit($k_miota, $k_menhely_nev, $k_nev);

    if ($sikeres) {
        header('Location: adminf.php');
    } else {
        echo "Hiba volt a beszúrásnál";
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// MENHELY
$m_kapacitas = $_POST['m_kapacitas'];
$m_nev = $_POST['m_nev'];

if ( isset($m_nev) && isset($m_kapacitas)) {

    $sikeres = menhelyet_modosit($m_kapacitas, $m_nev);

    if ($sikeres) {
        header('Location: adminf.php');
    } else {
        echo "Hiba volt a beszúrásnál";
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// OROKBEFOGADO
$o_nev = $_POST['o_nev'];
$o_regi = $_POST['o_regi'];

if ( isset($o_nev) && isset($o_regi)) {

    $sikeres = orokbefogadot_modosit($o_nev, $o_regi);

    if ($sikeres) {
        header('Location: adminf.php');
    } else {
        echo "Hiba volt a beszúrásnál";
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// ELEDEL
$el_mennyiseg = $_POST['el_mennyiseg'];
$el_menhely_nev = $_POST['el_menhely_nev'];
$el_marka = $_POST['el_marka'];
$el_tipus = $_POST['el_tipus'];


if (isset($el_mennyiseg) && isset($el_menhely_nev) && isset($el_marka) && isset($el_tipus)) {
    $sql = "SELECT marka, tipus FROM ELEDEL WHERE menhely_nev = '{$el_menhely_nev}'";
    $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));

    $szamlalo = 0;
    while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
        if ($current_row["marka"] == $el_marka && $current_row["tipus"] == $el_tipus) {
            $szamlalo++;
        }

        if ($szamlalo !== 0) {
            $sikeres = eledelt_modosit($el_mennyiseg, $el_menhely_nev, $el_marka, $el_tipus);

            if ($sikeres) {
                header('Location: adminf.php');
            } else {
                header('Location: hiba.php');
            }
        } else {
            header('Location: hiba.php');
        }
    }
}else {
    error_log("Nincs beállítva valamely érték");
}
