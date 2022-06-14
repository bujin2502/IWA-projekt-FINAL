<?php
include("../zajednicko/baza.php");

session_start();
if(isset($_SESSION['aktivni_korisnik_id']))
$aktivni_korisnik_id=$_SESSION['aktivni_korisnik_id'];

$naziv = $_POST['naziv'];
$poveznica = $_POST['poveznica'];
$opis = $_POST['opis'];

$bp=spojiSeNaBazu();
$sql = "INSERT INTO pjesma (korisnik_id, naziv, poveznica, opis, broj_svidanja) VALUES ('$aktivni_korisnik_id', '$naziv', '$poveznica', '$opis', 0)";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../moje_pjesme.php");
?>