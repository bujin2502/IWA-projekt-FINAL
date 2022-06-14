<?php
	include("zajednicko/zaglavlje.php");
	$bp=spojiSeNaBazu();

if (isset($_GET['pjesma_id'])) $id_pjesme = $_GET['pjesma_id'];

$sql = "SELECT p.naziv, p.datum_vrijeme_kreiranja, p.broj_svidanja, p.opis, k.ime, k.prezime, p.medijska_kuca_id, p.datum_vrijeme_kupnje FROM pjesma p, korisnik k, medijska_kuca m WHERE p.pjesma_id ={$id_pjesme} AND k.korisnik_id = p.korisnik_id AND (p.medijska_kuca_id = m.medijska_kuca_id OR p.medijska_kuca_id IS NULL)";
$rs = izvrsiUpit($bp, $sql);
	$pjesma_detalji = mysqli_fetch_array($rs);
    zatvoriVezuNaBazu($bp);

    echo "<p class='detalji_pjesme'>Naziv pjesme: " . $pjesma_detalji[0] . "</p>";
    $datum = strtotime ($pjesma_detalji[1]);
    $datum_prikaz = date("d.m.Y. H:i:s", $datum);
    echo "<p class='detalji_pjesme'>Datum kreiranja pjesme: " . $datum_prikaz . "</p>";
    echo "<p class='detalji_pjesme'>Broj sviđanja: " . $pjesma_detalji[2] . "</p>";
    echo "<p class='detalji_pjesme'>Opis pjesme: " . $pjesma_detalji[3] . "</p>";
    echo "<p class='detalji_pjesme'>Autor pjesme: " . $pjesma_detalji[4] . " " . $pjesma_detalji[5] . "</p>";
    if (empty($pjesma_detalji[7])) {
        echo "<p class='detalji_pjesme'>Pjesma još nije kupljena od medijske kuće</p>";
    } else {
        switch ($pjesma_detalji[6]) {
            case(1): echo "<p class='detalji_pjesme'>Pjesmu je kupila medijska kuća: 'Novi pokret'</p>";
            break;
            case(2): echo "<p class='detalji_pjesme'>Pjesmu je kupila medijska kuća: 'Klasika'</p>";
            break;
            case(3): echo "<p class='detalji_pjesme'>Pjesmu je kupila medijska kuća: 'Rokaši Studio'</p>";
            break;
            case(4): echo "<p class='detalji_pjesme'>Pjesmu je kupila medijska kuća: 'Mild One'</p>";
            break;
            case(5): echo "<p class='detalji_pjesme'>Pjesmu je kupila medijska kuća: 'Folklor'</p>";
            break;
            }
    }

if(isset($_SESSION['aktivni_korisnik']))
$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
        
$cookie_name = $id_pjesme . $aktivni_korisnik;
        
if(!isset($_COOKIE[$cookie_name])) {
    echo "<form id=like name=like method=POST action='action/dodaj_like.php'>";
    echo "<input type='hidden' id='pjesma' name='pjesma' value='$id_pjesme'>";
    echo "<button class='button-blue' type='submit'>Sviđa mi se</button>";
    echo "</form>";
} else {
    echo "<p class='detalji_pjesme' style='color: gray'>Već ste lajkali pjesmu</p>";
    }

	include("zajednicko/podnozje.php");
?>