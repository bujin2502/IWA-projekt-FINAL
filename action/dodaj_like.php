<?php

include("../zajednicko/baza.php");

session_start();
if(isset($_SESSION['aktivni_korisnik']))
$aktivni_korisnik=$_SESSION['aktivni_korisnik'];

$bp=spojiSeNaBazu();
$id_pjesme = $_POST['pjesma'];
$sql = "UPDATE pjesma SET broj_svidanja = broj_svidanja + 1, datum_vrijeme_kreiranja = datum_vrijeme_kreiranja WHERE pjesma_id=$id_pjesme";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

$cookie_name = $id_pjesme . $aktivni_korisnik;
setcookie($cookie_name, $cookie_name, time() + 60*60*24*30*12*10, "/");

header("Location: ../detalji_pjesme.php?pjesma_id=$id_pjesme");
?>