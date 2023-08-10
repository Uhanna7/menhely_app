<?php

include_once('common/db_fuggvenyek.php');


// DOLGOZO
$toroltdolgozo = $_POST['toroltdolgozo'];

if ( isset($toroltdolgozo) ) {

    $sikeres = dolgozo_torles($toroltdolgozo);

    if ( $sikeres ) {
        header('Location: adminf.php');
    } else {
        echo 'Hiba történt';
    }

} else {
    echo 'Hiba történt';

}


// KUTYA
$toroltkutya = $_POST['toroltkutya'];

if ( isset($toroltkutya) ) {

    $sikeres = kutya_torles($toroltkutya);

    if ( $sikeres ) {
        header('Location: adminf.php');
    } else {
        echo 'Hiba történt';
    }

} else {
    echo 'Hiba történt';

}


// MENHELY
$toroltmenhely = $_POST['toroltmenhely'];

if ( isset($toroltmenhely) ) {

    $sikeres = menhely_torles($toroltmenhely);

    if ( $sikeres ) {
        header('Location: adminf.php');
    } else {
        echo 'Hiba történt';
    }

} else {
    echo 'Hiba történt';

}


// OROKBEFOGADAS
$v_kutyanev = $_POST['kutyanev'];

if ( isset($v_kutyanev) ) {

    $sikeres = orokbefogadas_torles($v_kutyanev);

    if ( $sikeres ) {
        header('Location: adminf.php');
    } else {
        echo 'Hiba történt';
    }

} else {
    echo 'Hiba történt';

}


// OROKBEFOGADO
$toroltorokbefogado = $_POST['toroltorokbefogado'];

if ( isset($toroltorokbefogado) ) {

    $sikeres = orokbefogado_torles($toroltorokbefogado);

    if ( $sikeres ) {
        header('Location: adminf.php');
    } else {
        echo 'Hiba történt';
    }

} else {
    echo 'Hiba történt';

}