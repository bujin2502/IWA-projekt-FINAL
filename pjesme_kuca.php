<?php
	include("zajednicko/zaglavlje.php");

    if(isset($_SESSION['aktivni_korisnik_id']))
    $aktivni_korisnik_id=$_SESSION['aktivni_korisnik_id'];

    if(isset($_SESSION['aktivni_korisnik_id']))
    $aktivni_korisnik_mk=$_SESSION['aktivni_korisnik_medijska_kuca'];

    $bp=spojiSeNaBazu();
    $sql = "SELECT medijska_kuca_id, naziv FROM medijska_kuca";
    $rs = izvrsiUpit($bp, $sql);
    while (list($medijska_kuca_id, $medijska_kuca_naziv) = mysqli_fetch_array($rs)) {
        $medijske_ukupno[$medijska_kuca_id] = $medijska_kuca_naziv;
    }

    echo "<p class='obavijest'>Prikaz svih kupljenih i zatraženih pjesama od \"$medijske_ukupno[$aktivni_korisnik_mk]\"</p>";
    echo "<table class='tablica'>";
    echo "<tr>";
    echo "<th>Pjesma</th>";
    echo "<th>Status</th>";
    echo "</tr>";

    $bp=spojiSeNaBazu();

    $sql = "SELECT p.naziv, p.medijska_kuca_id, p.datum_vrijeme_kupnje FROM pjesma p, korisnik k, medijska_kuca mk WHERE k.korisnik_id = $aktivni_korisnik_id AND p.medijska_kuca_id = k.medijska_kuca_id AND k.medijska_kuca_id = mk.medijska_kuca_id ORDER BY p.datum_vrijeme_kupnje";

    $rs = izvrsiUpit($bp, $sql);
    zatvoriVezuNaBazu($bp);
    while (list($pjesma_ime, $medijska_kuca_trazi, $datum_kupnje) = mysqli_fetch_array($rs)) {
    echo "<tr style='padding:10px'><td>$pjesma_ime</td>";
    if ((!empty($medijska_kuca_trazi)) && (!empty($datum_kupnje))) {
        echo "<td>Kupljeno</td></tr>\n";
    } else if ((!empty($medijska_kuca_trazi)) && (empty($datum_kupnje))) {
        echo "<td>Čeka odobrenje</td></tr>\n";
    }
}
echo "</table>";


	include("zajednicko/podnozje.php");
?>