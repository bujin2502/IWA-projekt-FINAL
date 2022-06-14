<?php
include("../zajednicko/baza.php");

$tip_kuca = $_POST['tip_kuca'];
$korisnik_id = $_POST['korisnik_id'];
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$korime = $_POST['korime'];
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];

list($tip_kor, $med_kuca_id) = explode("#", $tip_kuca);

$bp=spojiSeNaBazu();

if ($med_kuca_id==0) {
    $sql = "UPDATE korisnik SET tip_korisnika_id='$tip_kor', medijska_kuca_id=NULL, korime='$korime', ime='$ime', prezime='$prezime',email='$email', lozinka='$lozinka' WHERE korisnik_id='$korisnik_id'";
} else {
    $sql = "UPDATE korisnik SET tip_korisnika_id='$tip_kor', medijska_kuca_id='$med_kuca_id', korime='$korime', ime='$ime', prezime='$prezime',email='$email', lozinka='$lozinka' WHERE korisnik_id='$korisnik_id'";
}

$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../unos_korisnika.php#$korisnik_id");
?>