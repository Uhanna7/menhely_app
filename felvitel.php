<?php
include_once('common/db_fuggvenyek.php');

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}

// DOLGOZO
$d_szigszam = $_POST['d_szigszam'];
$d_nev = $_POST['d_nev'];
$d_nem = $_POST['d_nem'];
$d_szul_datum = $_POST['d_szul_datum'];
$d_menhely_nev = $_POST['d_menhely_nev'];


if ( isset($d_szigszam) && isset($d_nev) && isset($d_nem) && isset($d_szul_datum) && isset($d_menhely_nev)) {

    $sikeres = dolgozot_beszur($d_szigszam, $d_nev, $d_nem, $d_szul_datum, $d_menhely_nev);

    if ($sikeres) {
        header('Location: adminf.php');
    } else {
        echo "Hiba volt a beszúrásnál";
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// KUTYA
$k_nev = $_POST['k_nev'];
$k_nem = $_POST['k_nem'];
$k_szul_ev = $_POST['k_szul_ev'];
$k_fajta = $_POST['k_fajta'];
$k_miota = $_POST['k_miota'];
$k_menhely_nev = $_POST['k_menhely_nev'];

$k_marka = $_POST['k_marka'];
$k_tipus = $_POST['k_tipus'];

if ( isset($k_nev) && isset($k_nem) && isset($k_szul_ev) && isset($k_fajta) && isset($k_miota) && isset($k_menhely_nev) && isset($k_marka) && isset($k_tipus)) {

    // megnezi hogy van-e mar ilyen nevu kutya az adatbazisban
    $van_e = van_e();
    $szamlalo = 0;
    while ( ($current_row = mysqli_fetch_assoc($van_e))!= null) {
        if ($current_row["nev"] === $k_nev){
            $szamlalo++;
        }
    }

    if ($szamlalo !== 0 ) {
        header('Location: hiba.php');
    }else {
        $sql = "SELECT marka, tipus FROM ELEDEL WHERE menhely_nev = '{$k_menhely_nev}'";
        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));

        $szamlalo2 = 0;
        while ( ($current_row = mysqli_fetch_assoc($res))!= null) {
            if ($current_row["marka"] === $k_marka && $current_row["tipus"] === $k_tipus) {
                $szamlalo2++;
            }
        }

        if($szamlalo2 !== 0) {
            $sikeres = kutyat_beszur($k_nev, $k_nem, $k_szul_ev, $k_fajta, $k_miota, $k_menhely_nev);
            $sikeres1 = eszi_beszur($k_nev, $k_menhely_nev, $k_marka, $k_tipus);

            if ($sikeres1 && $sikeres) {
                header('Location: adminf.php');
            } else {
                header('Location: hiba.php');
            }
        }else {
            header('Location: hiba.php');
        }
    }
}else {
    error_log("Nincs beállítva valamely érték");
}


// MENHELY
$m_nev = $_POST['m_nev'];
$m_kapacitas = $_POST['m_kapacitas'];
$m_varos = $_POST['m_varos'];
$m_utca = $_POST['m_utca'];
$m_hazszam = $_POST['m_hazszam'];

if ( isset($m_nev) && isset($m_kapacitas) &&
    isset($m_varos) && isset($m_utca) && isset($m_hazszam)) {

    $sikeres = menhelyet_beszur($m_nev, $m_kapacitas, $m_varos, $m_utca, $m_hazszam);

    if ($sikeres == true) {
        header("Location: adminf.php");
    } else {
        echo "Hiba volt a beszúrásnál";
    }
} else {
    error_log("Nincs beállítva valamely érték");
}


// ONKENTES
$on_szigszam = $_POST['on_szigszam'];
$on_nev = $_POST['on_nev'];
$on_nem = $_POST['on_nem'];
$on_szul_datum = $_POST['on_szul_datum'];
$on_menhely_nev = $_POST['on_menhely_nev'];

if ( isset($on_szigszam) && isset($on_nev) &&
    isset($on_nem) && isset($on_szul_datum) && isset($on_menhely_nev) ) {

    $sikeres = onkentest_beszur($on_szigszam, $on_nev, $on_nem, $on_szul_datum, $on_menhely_nev);
    if ($sikeres == true) {
        header("Location: index.php");
    } else {
        echo "Hiba volt a beszúrásnál";
    }
} else {
    error_log("Nincs beállítva valamely érték");

}


// UJ OROKBEFOGADO
$uj_kod = $_POST['uj_kod'];
$uj_szigszam = $_POST['uj_szigszam'];
$uj_nev = $_POST['uj_nev'];
$uj_nem = $_POST['uj_nem'];
$uj_szul_datum = $_POST['uj_szul_datum'];


// 1. orokbefogado szemely hozzaadas
if ( isset($uj_szigszam) && isset($uj_nev) &&
    isset($uj_nem) && isset($uj_szul_datum)) {

    $sikeres = orokbefogadot_beszur($uj_szigszam, $uj_nev, $uj_nem, $uj_szul_datum);

    if ($sikeres == true) {
        if (isset($uj_szigszam) && isset($uj_kod)) {

            // 2. kutya szigszam es mikor modositas
            $sikeres1 = orokbefogadas_kutya_modositas($uj_szigszam, $uj_kod);
            if ($sikeres1 == true) {
                header('Location: orokbefogadok_kezdes.php');
            } else {
                echo 'Hiba történt a felvitelnél';
            }
        } else {
            echo "Hiba volt a beszúrásnál";
        }
    } else {
        error_log("Nincs beállítva valamely érték");
    }
} else {
    echo 'Hiba történt a felvitelnél';
}


// REGI OROKBEFOGADO
$o_nev = $_POST['o_nev'];
$o_kod = $_POST['o_kod'];

if (isset($o_nev) && isset($o_kod)) {

    $sikeres = orokbefogadas_kutya_modositas_masik($o_nev, $o_kod);

    if ($sikeres == true) {
        header('Location: orokbefogadok_kezdes.php');
    } else {
        echo 'Hiba történt a felvitelnél';
    }

} else {
    error_log("Nincs beállítva valamely érték");
}


// ELEDEL
$e_marka = $_POST['e_marka'];
$e_tipus = $_POST['e_tipus'];
$e_mennyiseg = $_POST['e_mennyiseg'];
$e_menhely_nev = $_POST['e_menhely_nev'];

if ( isset($e_marka) && isset($e_tipus) &&
    isset($e_mennyiseg) && isset($e_menhely_nev)) {

    if ( !($conn = menhely_csatlakozas()) ) { // ha nem sikerult csatlakozni, akkor kilepunk
        return false;
    }

    $sql = mysqli_query($conn, "SELECT COUNT(keszlet_kod) AS eredmeny FROM Eledel WHERE marka = '{$e_marka}' AND tipus = '{$e_tipus}' AND menhely_nev = '{$e_menhely_nev}'");

    $sikeres = false;
    $current_row = mysqli_fetch_row($sql);
    if ($current_row[0] == 0) {
        $sikeres = eledelt_beszur($e_marka, $e_tipus, $e_mennyiseg, $e_menhely_nev);
        if ($sikeres == true) {
            header("Location: keszletek.php");
        } else {
            echo "Hiba volt a beszúrásnál";
        }
    } else if ($current_row[0]  == 1) {
        $sikeres = eledelt_hozzaad($e_mennyiseg, $e_marka, $e_tipus, $e_menhely_nev);
        if ($sikeres == true) {
            header("Location: keszletek.php");
        } else {
            echo "Hiba volt a beszúrásnál";
        }
    } else {
        echo 'mar megint szar';
    }

} else {
    error_log("Nincs beállítva valamely érték");
}
