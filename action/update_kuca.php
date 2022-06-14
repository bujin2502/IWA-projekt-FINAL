<?php
include("../zajednicko/baza.php");

$medijska_kuca_id = $_POST['kuca_id'];
$naziv = $_POST['naziv'];
$opis = $_POST['opis'];

$bp=spojiSeNaBazu();
$sql = "UPDATE medijska_kuca SET naziv = '$naziv', opis = '$opis' WHERE medijska_kuca_id = $medijska_kuca_id";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../unos_kuce.php");
?>