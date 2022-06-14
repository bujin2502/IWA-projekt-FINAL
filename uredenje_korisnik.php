<?php
include("zajednicko/zaglavlje.php");

$bp=spojiSeNaBazu();
$korisnik_id = $_GET['korisnik_id'];
$sql = "SELECT tip_korisnika_id, medijska_kuca_id, korime, ime, prezime, email, lozinka FROM korisnik WHERE korisnik_id=$korisnik_id";
$rs = izvrsiUpit($bp, $sql);
$korisnik_array = mysqli_fetch_assoc($rs);



echo "<form class='forma' name='izmjena_korisnik' method='POST' action='action/izmjena_korisnik.php'>";


echo "<label for='ime'>Ime: </label>";
echo "<input type='text' name='ime' required='required' value='$korisnik_array[ime]'><br>";

echo "<label for='prezime'>Prezime: </label>";
echo "<input type='text' name='prezime' required='required' value='$korisnik_array[prezime]'><br>";

echo "<label for='korime'>Korisničko ime: </label>";
echo "<input type='text' name='korime' required='required' value='$korisnik_array[korime]'><br>";

echo "<label for='email'>E-mail: </label>";
echo "<input type='text' name='email' required='required' value='$korisnik_array[email]'><br>";

echo "<label for='lozinka'>Lozinka: </label>";
echo "<input type='text' name='lozinka' required='required' value='$korisnik_array[lozinka]'><br>";
?>

<label for="tip_kuca">Tip korisnika / Medijska kuća*: </label>
<select required="required" id="tip_kuca" name="tip_kuca">
	<option value="0#0">Administrator (nema medijsku kuću)</option>
<?php
$sql = "SELECT medijska_kuca_id, naziv FROM medijska_kuca";
$rs = izvrsiUpit($bp, $sql);
zatvoriVezuNaBazu($bp);
while (list($medijska_kuca_id, $medijska_kuca_naziv) = mysqli_fetch_array($rs)) {
	echo "<option value='1#{$medijska_kuca_id}'>Moderator - medijska kuća \"{$medijska_kuca_naziv}\"</option>\n";
}
?>
	<option value="2#0" selected>Korisnik (nema medijsku kuću)</option>
</select>
<?php

echo "<input type='hidden' name='korisnik_id' value='$korisnik_id'><br>";
echo "<button type='submit'>Izmjeni podatke korisnika</button>";
echo "</form>";

include("zajednicko/podnozje.php");
?>