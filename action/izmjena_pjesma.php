<?php
include("../zajednicko/baza.php");

$pjesma_id = $_POST['pjesma_id'];
$naziv = $_POST['naziv'];
$poveznica = $_POST['poveznica'];
$opis = $_POST['opis'];

$bp=spojiSeNaBazu();
$sql = "UPDATE pjesma SET naziv='$naziv', poveznica='$poveznica', opis='$opis', datum_vrijeme_kreiranja = datum_vrijeme_kreiranja WHERE pjesma_id='$pjesma_id'";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../moje_pjesme.php");
?>