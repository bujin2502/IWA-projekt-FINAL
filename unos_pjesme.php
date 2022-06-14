<?php
include("zajednicko/zaglavlje.php");
?>
<form class="forma" name="unos_pjesme" method="POST" action="action/unos_pjesma.php">
<p><strong>Obvezan je unos svih polja</strong></p>
<label for="naziv">Naziv pjesme*</label>
<input type="text" required="required" id="naziv" name="naziv"></input><br>
<label for="poveznica">Poveznica na pjesmu*</label>
<input type="url" required="required" id="poveznica" name="poveznica"></input><br>
<label for=opis>Opis pjesme*</label>
<textarea id="opis" required="required" name="opis" rows="4" cols="50"></textarea><br>
<button type="submit">Unesi pjesmu</button>
</form>
<?php
include("zajednicko/podnozje.php");
?>