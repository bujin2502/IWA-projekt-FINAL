<?php
include("../zajednicko/baza.php");

$tip_kuca = $_POST['tip_kuca'];
$korime = $_POST['korime'];
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$email = $_POST['email'];
$lozinka = $_POST['password'];

list($tip_kor, $med_kuca_id) = explode("#", $tip_kuca);

$bp=spojiSeNaBazu();

if ($med_kuca_id==0) {
    $sql = "INSERT INTO korisnik (tip_korisnika_id, korime, ime, prezime, email, lozinka) VALUES ('$tip_kor', '$korime', '$ime', '$prezime', '$email', '$lozinka')";
} else {
    $sql = "INSERT INTO korisnik (tip_korisnika_id, medijska_kuca_id, korime, ime, prezime, email, lozinka) VALUES ('$tip_kor', '$med_kuca_id','$korime', '$ime', '$prezime', '$email', '$lozinka')";
}

$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);

header("Location: ../unos_korisnika.php");
?>