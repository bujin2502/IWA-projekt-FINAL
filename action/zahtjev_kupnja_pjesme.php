<?php
include("../zajednicko/baza.php");

$pjesma_id = $_GET['pjesma_id'];
$medijska_id = $_GET['medijska_id'];

$bp=spojiSeNaBazu();
$sql = "UPDATE pjesma SET datum_vrijeme_kreiranja = datum_vrijeme_kreiranja, medijska_kuca_id=$medijska_id WHERE pjesma_id=$pjesma_id";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location:../index.php");
?>