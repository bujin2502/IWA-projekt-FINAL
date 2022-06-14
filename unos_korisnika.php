<?php
include("zajednicko/zaglavlje.php");
if (($aktivni_korisnik_tip)!=0){
	header("Location: ../index.php");
}

$bp=spojiSeNaBazu();
$sql = "SELECT tip_korisnika_id, naziv FROM tip_korisnika";
$rs = izvrsiUpit($bp, $sql);
while (list($tip_korisnika_id, $tip_korisnika_naziv) = mysqli_fetch_array($rs)) {
	$tip_korisnika[$tip_korisnika_id] = $tip_korisnika_naziv;
}
?>

<p><span style='font-weight: bold'>Unos korisnika. </span>Pri unosu novog korisnika potrebno je unijeti sva polja.</p>
<p><span style='font-weight: bold; color: red'>Napomena: </span>Početna korisnička lozinka pri kreiranju novog korisnika je "123456" koja se može izmjeniti unosom u formu.</p>
<form class="form-inline" method="POST" name="form" action="action/unos_korisnik.php">
<div>
<label for="ime">Ime*: </label>
<input required="required" name="ime">
<label for="prezime">Prezime*: </label>
<input required="required" name="prezime">
<label for="email">E-mail*: </label>
<input type="email" required="required" name="email">
</div>
<div>
<label for="korime">Korisničko ime*: </label>
<input required="required" name="korime">
<label for="password">Lozinka*: </label>
<input required="required" name="password" value="123456">
</div>
<div>
<label for="tip_kuca">Tip korisnika / Medijska kuća*: </label>
<select required="required" id="tip_kuca" name="tip_kuca">
	<option value="0#0">Administrator (nema medijsku kuću)</option>
<?php
$sql = "SELECT medijska_kuca_id, naziv FROM medijska_kuca";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);
while (list($medijska_kuca_id, $medijska_kuca_naziv) = mysqli_fetch_array($rs)) {
	$medijska_kuca[$medijska_kuca_id] = $medijska_kuca_naziv;
	echo "<option value='1#{$medijska_kuca_id}'>Moderator - medijska kuća \"{$medijska_kuca_naziv}\"</option>\n";
}
?>
	<option value="2#0" selected>Korisnik (nema medijsku kuću)</option>
</select>
</div>
<div>
<button type="submit" name="submit">Unesi novog korisnika</button>
</div>
</form><br>
<table class="tablica">
	<tr>
		<th>Tip korisnika</th>
		<th>Medijska kuća</th>
		<th>Korisničko ime</th>
		<th>Ime</th>
		<th>Prezime</th>
		<th>E-mail</th>
		<th>Lozinka</th>
		<th>Uređenje podataka</th>
	</tr>
<?php

$bp=spojiSeNaBazu();
$sql = "SELECT * FROM korisnik";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);
while (list($korisnik_id, $tip_korisnika_id, $medijska_kuca_id, $korime, $ime, $prezime, $email, $lozinka) = mysqli_fetch_array($rs)) {
	echo "<tr id='$korisnik_id'><td>" . ucfirst($tip_korisnika[$tip_korisnika_id]) . "</td>";
	if (isset($medijska_kuca_id)) {
		echo "<td>$medijska_kuca[$medijska_kuca_id]</td>";
	} else {
		echo "<td></td>";
	}
	echo "<td>$korime</td><td>$ime</td><td>$prezime</td><td>$email</td>";
	echo "<td>" . preg_replace("|.|","*",$lozinka) . "</td>";
	echo "<td><a href='uredenje_korisnik.php?korisnik_id=$korisnik_id'><button class='button-blue'>Uredi</button></a></td>\n";
	}
	if (!$rs) {
		echo "Problem kod upita na bazu podataka!";
	}
?>