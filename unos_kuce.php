<?php
include("zajednicko/zaglavlje.php");
if (($aktivni_korisnik_tip)!=0){
	header("Location: ../index.php");
}
?>

<p><span style='font-weight: bold'>Unos medijske kuće</span></p>
<form class="forma" method="POST" name="form" action="action/unos_kuca.php">
<p><strong>Obvezan je unos svih polja</strong></p>
<label for="medijska_naziv">Naziv medijske kuće*</label>
<input required="required" name="medijska_naziv">
<label for="medijska_opis">Opis*</label>
<input required="required" name="medijska_opis"></textarea>
<button type="submit" name="submit">Unesi novu medijsku kuću</button>
</form><br>

<?php
echo "<table class='tablica'>";
echo "<tr>";
echo "<th>Naziv medijske kuće</th>";
echo "<th>Opis</th>";
echo "<th>Broj sviđanja</th>";
echo "<th>Uređenje podataka</th>";
echo "</tr>";
echo "<tr>";

$bp=spojiSeNaBazu();

$sql = "SELECT medijska_kuca_id, naziv, opis FROM medijska_kuca";
$rs = izvrsiUpit($bp, $sql);

$sql = "SELECT m.medijska_kuca_id, SUM(p.broj_svidanja) as ukupan_broj_svidanja FROM pjesma p, medijska_kuca m WHERE p.medijska_kuca_id=m.medijska_kuca_id AND p.datum_vrijeme_kupnje IS NOT NULL GROUP BY p.medijska_kuca_id";
$broj_svidanja = izvrsiUpit($bp, $sql);

zatvoriVezuNaBazu($bp);

while (list($id_svid, $broj_svid) = mysqli_fetch_array($broj_svidanja)) {
	$kuca_svidanja[$id_svid] = $broj_svid;
}

while (list($id, $naziv, $opis) = mysqli_fetch_array($rs)) {
	if ((isset($_GET['id'])) && $id == $_GET['id']) {
		echo "<form class='forma' name='update_kuca' action='action/update_kuca.php' method='POST'>";
		echo "<td><textarea name='naziv' required='required'>$naziv</textarea></td>";
		echo "<td><textarea name='opis'  required='required'>$opis</textarea></td>";
		if (isset($kuca_svidanja[$id])) {
			echo "<td>$kuca_svidanja[$id]</td>";
		} else if (empty($kuca_svidanja[$id])) {
			echo "<td></td>";
		}
		echo "<input hidden='hidden' name='kuca_id'value='$id'>";
		echo "<td><button type='submit' class='button-green'>Spremi</button></td></tr>\n";
		echo "</form>";
	} else {
		echo "<td>$naziv</td>";
		echo "<td>$opis</td>";
		if (isset($kuca_svidanja[$id])) {
			echo "<td>$kuca_svidanja[$id]</td>";
		} else if (empty($kuca_svidanja[$id])) {
			echo "<td>0</td>";
		}
		echo "<td><a href='unos_kuce.php?id=$id'><button class='button-blue'>Uredi</button></a></td></tr>\n";
	}
}
	if (!$rs) {
		echo "Problem kod upita na bazu podataka!";
	}
?>