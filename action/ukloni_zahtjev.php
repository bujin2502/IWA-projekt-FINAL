<?php
include("../zajednicko/baza.php");

$bp=spojiSeNaBazu();
$pjesma_id = $_GET['pjesma_id'];
$sql = "UPDATE pjesma SET medijska_kuca_id=NULL, datum_vrijeme_kreiranja = datum_vrijeme_kreiranja WHERE pjesma_id=$pjesma_id";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../moje_pjesme.php");
?>