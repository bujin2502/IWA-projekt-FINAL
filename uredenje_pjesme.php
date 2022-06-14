<?php
include("zajednicko/zaglavlje.php");

$bp=spojiSeNaBazu();
$pjesma_id = $_GET['pjesma_id'];
$sql = "SELECT naziv, poveznica, opis FROM pjesma WHERE pjesma_id=$pjesma_id";
$rs = izvrsiUpit($bp, $sql);
$pjesma_array = mysqli_fetch_assoc($rs);
zatvoriVezuNaBazu($bp);
echo "<form class='forma' name='izmjena_pjesma' method='POST' action='action/izmjena_pjesma.php'>";
echo "<p><strong>Obvezan je unos svih polja</strong></p>";
echo "<label for='naziv'>Naziv pjesme*</label>";
echo "<input type='text' name='naziv' required='required' value='$pjesma_array[naziv]'><br>";
echo "<label for='poveznica'>Poveznica pjesme*</label>";
echo "<input type='url' name='poveznica' required='required' value='$pjesma_array[poveznica]'><br>";
echo "<label for='opis'>Opis pjesme*</label>";
echo "<textarea name='opis' required='required' rows='4' cols='50'>$pjesma_array[opis]</textarea><br>";
echo "<input type='hidden' name='pjesma_id' value='$pjesma_id'>";
echo "<button type='submit'>Izmjeni podatke pjesme</button>";
echo "</form>";

include("zajednicko/podnozje.php");
?>