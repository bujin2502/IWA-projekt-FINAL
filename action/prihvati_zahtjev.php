<?php
include("../zajednicko/baza.php");

$bp=spojiSeNaBazu();
$pjesma_id = $_GET['pjesma_id'];
$sql = "UPDATE pjesma SET datum_vrijeme_kupnje=NOW(), datum_vrijeme_kreiranja = datum_vrijeme_kreiranja WHERE pjesma_id=$pjesma_id";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../moje_pjesme.php");
?>