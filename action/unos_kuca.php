<?php
include("../zajednicko/baza.php");

$medijska_naziv = $_POST['medijska_naziv'];
$medijska_opis = $_POST['medijska_opis'];

$bp=spojiSeNaBazu();
$sql = "INSERT INTO medijska_kuca (naziv, opis) VALUES ('$medijska_naziv', '$medijska_opis')";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../unos_kuce.php");
?>