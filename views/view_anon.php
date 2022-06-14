<?php
if (($aktivni_korisnik_tip)!=-1){
	header("Location: ../index.php");
}

?>
<h2>Pregled svih kupljenih pjesama</h2>
<p>Prikazane pjesme su kupljene od neke od medijskih kuća i složene su po broju sviđanja.</p>
<table class='tablica'>
	<tr>
		<th>Pjesma</th>
		<th>Autor<br>korisničko ime</th>
		<th>Broj sviđanja</th>
	</tr>
		<?php
		$bp=spojiSeNaBazu();
		$sql = "SELECT p.poveznica, k.korime, p.broj_svidanja, p.naziv FROM pjesma p, korisnik k WHERE k.korisnik_id = p.korisnik_id AND p.datum_vrijeme_kupnje IS NOT NULL AND p.medijska_kuca_id IS NOT NULL ORDER BY p.broj_svidanja DESC";
		$rs = izvrsiUpit($bp, $sql);
		zatvoriVezuNaBazu($bp);
		while (list($audio_zapis, $autor_kori_ime, $svidanja, $pjesma) = mysqli_fetch_array($rs)) {
		echo "<tr><td>$pjesma<br><br><audio controls><source src='$audio_zapis' type='audio/mpeg'></audio></td><td> $autor_kori_ime</td><td>$svidanja</td></tr>\n";}
		?>
</table>