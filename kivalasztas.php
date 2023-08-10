<?php
include_once('common/db_fuggvenyek.php');

if ( !($conn = menhely_csatlakozas()) ) {
    return false;
}

$v_menhely_nev = $_POST['menhely_nev'];

if (isset($v_menhely_nev)) {
    $kivalasztott = kivalasztott_menhely($v_menhely_nev);

}else {
    echo 'Hiba történt a felvitelnél';
}


