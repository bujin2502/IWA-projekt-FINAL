<?php
if (($aktivni_korisnik_tip)!=2){
	header("Location: ../index.php");
}
?>
<p><span style='font-weight: bold'>Forma za pretraživanje. </span>Datum se upisuje u obliku dd.mm.gggg (bez točke na kraju).</p>

<form class="form-inline" method="POST" name="form" action="<?php $_SERVER['PHP_SELF'] ?>">
<label for="med_kuca">Medijska kuća: </label>
<select id="med_kuca" name="med_kuca">
	<option value="0">Sve medijske kuće</option>
<?php
$bp=spojiSeNaBazu();
$sql = "SELECT medijska_kuca_id, naziv FROM medijska_kuca";
$rs = izvrsiUpit($bp, $sql);
while (list($medijska_kuca_id, $medijska_kuca_naziv) = mysqli_fetch_array($rs)) {
	$medijska_kuca[$medijska_kuca_id] = $medijska_kuca_naziv;
	echo "<option value='{$medijska_kuca_id}'>{$medijska_kuca_naziv}</option>\n";
}
?>
</select>
<label for="odDatuma">Od datuma: </label>
<input name="odDatuma" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}">
<label for="doDatuma">Do datuma: </label>
<input name="doDatuma" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}">
<button type="submit" name="submit">Pretraži</button>
</form>
<?php
function tablica ($sql) {
    echo "<table class='tablica'>";
	echo "<tr>";
	echo "<th>Pjesma</th>";
	echo "<th>Autor<br>korisničko ime</th>";
	echo "<th>Broj sviđanja</th>";
	echo "<th>Datum i vrijeme kreiranja</th>";
	echo "</tr>";
	$bp=spojiSeNaBazu();
    $rs = izvrsiUpit($bp, $sql);
	zatvoriVezuNaBazu($bp);
	while (list($audio_zapis, $autor_korisnicko_ime, $svidanja, $pjesma, $pjesma_id, $med_kuca, $vrijeme_kreiranja) = mysqli_fetch_array($rs)) {
	$datum = strtotime ($vrijeme_kreiranja);
	$datum_prikaz = date("d.m.Y H:i:s", $datum);
	echo "<tr><td><a href='detalji_pjesme.php?pjesma_id=$pjesma_id'>$pjesma</a><br><br><audio controls><source src='$audio_zapis' type='audio/mpeg'></audio></td><td>$autor_korisnicko_ime</td><td>$svidanja</td><td>$datum_prikaz</td></tr>\n";}
	echo "</table>";
	if (!$rs) {
		echo "Problem kod upita na bazu podataka!";
	}
}

if (isset($_POST['submit'])) {

if (isset($_POST['med_kuca']) && (!isset($_POST['odDatuma']) || empty($_POST['odDatuma'])) && (!isset($_POST['doDatuma']) || empty($_POST['doDatuma']))) {
	$med_kuca = $_POST['med_kuca'];

    if ($med_kuca == 0) {
		$sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv, p.pjesma_id, p.medijska_kuca_id, p.datum_vrijeme_kreiranja FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id AND p.medijska_kuca_id IS NOT NULL AND p.datum_vrijeme_kupnje IS NOT NULL";
		echo "<p class='obavijest'>Sve kupljene pjesme.</p>";
	} else {
		$sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv, p.pjesma_id, p.medijska_kuca_id, p.datum_vrijeme_kreiranja FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id AND p.medijska_kuca_id ='$med_kuca' AND p.datum_vrijeme_kupnje IS NOT NULL";
		echo "<p class='obavijest'>\"" . $medijska_kuca[$_POST['med_kuca']] . "\" je kupila sljedeće pjesme.</p>";
	}


	
	tablica($sql);

} else  {
		if (isset($_POST['med_kuca'])) $med_kuca = $_POST['med_kuca'];

		if ((!isset($_POST['odDatuma'])) || (empty($_POST['odDatuma']))) {
			$odDatuma = '1970-01-01';
			$datum = strtotime ($odDatuma);
			$odDatuma_prikaz = date('d.m.Y', $datum);
		} else {
			$pd = date_create_from_format('d.m.Y', $_POST['odDatuma']);
			$odDatuma = date_format($pd, 'Y-m-d');
			$odDatuma_prikaz = date_format($pd, 'd.m.Y');
		}

		if ((!isset($_POST['doDatuma'])) || (empty($_POST['doDatuma']))) {
			$doDatuma = date('Y-m-d');
			$doDatuma_prikaz = date('d.m.Y');
		} else {
			$pd = date_create_from_format('d.m.Y', $_POST['doDatuma']);
			$doDatuma = date_format($pd, 'Y-m-d');
			$doDatuma_prikaz = date_format($pd, 'd.m.Y');
		}

        if ($med_kuca == 0) {
            $sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv, p.pjesma_id, p.medijska_kuca_id, p.datum_vrijeme_kreiranja FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id AND p.medijska_kuca_id IS NOT NULL AND p.datum_vrijeme_kupnje IS NOT NULL AND (p.datum_vrijeme_kreiranja BETWEEN '$odDatuma' AND '$doDatuma')";
			echo "<p class='obavijest'>Sve kupljene pjesme u vremenu od " . $odDatuma_prikaz . " do  " . $doDatuma_prikaz . "</p>";
        } else {
            $sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv, p.pjesma_id, p.medijska_kuca_id, p.datum_vrijeme_kreiranja FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id AND p.medijska_kuca_id =$med_kuca AND p.datum_vrijeme_kupnje IS NOT NULL AND (p.datum_vrijeme_kreiranja BETWEEN '$odDatuma' AND '$doDatuma')";
			echo "<p class='obavijest'>\"" . $medijska_kuca[$_POST['med_kuca']] . "\" je kupila pjesme u vremenu od " . $odDatuma_prikaz . " do  " . $doDatuma_prikaz . "</p>";
        }

	    tablica($sql);
}
} else {
    $sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv, p.pjesma_id, p.medijska_kuca_id, p.datum_vrijeme_kreiranja FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id ORDER BY p.datum_vrijeme_kreiranja DESC";
    echo "<p class='obavijest'>Tablica prikazuje sve pjesme</p>";
    tablica($sql);
	}
?>