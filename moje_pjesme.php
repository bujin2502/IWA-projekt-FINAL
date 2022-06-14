<?php
	include("zajednicko/zaglavlje.php");

    if(isset($_SESSION['aktivni_korisnik_id']))
    $aktivni_korisnik_id=$_SESSION['aktivni_korisnik_id'];

    echo "<p class='obavijest'>Tablica prikazuje sve pjesme korisnika</p>";
		
    echo "<table class='tablica'>";
    echo "<tr>";
    echo "<th>Moje pjesme</th>";
    echo "<th>Opis</th>";
    echo "<th>Datum i vrijeme kreiranja</th>";
    echo "<th>Datum i vrijeme kupnje</th>";
    echo "<th>Status kupovine</th>";
    echo "<th>Ažuriranje pjesme</th>";
    echo "</tr>";
            $bp=spojiSeNaBazu();
            $sql = "SELECT naziv, poveznica, opis, datum_vrijeme_kreiranja, datum_vrijeme_kupnje, medijska_kuca_id, pjesma_id 
            FROM pjesma WHERE korisnik_id = $aktivni_korisnik_id";
            $rs = izvrsiUpit($bp, $sql);
            zatvoriVezuNaBazu($bp);
            while (list($pjesma_ime, $pjesma_link, $pjesma_opis, $pjesma_datum_vrijeme_kreiranja, $pjesma_datum_vrijeme_kupnje, $medijska_kuca_id, $pjesma_id) = mysqli_fetch_array($rs)) {
                
                $datum = strtotime ($pjesma_datum_vrijeme_kreiranja);
                $datum_prikaz = date("d.m.Y H:i:s", $datum);
                
                if (empty($pjesma_datum_vrijeme_kupnje)) {
                    $pjesma_datum_kupnje = 'Nije prodana';
                } else {
                    $datum1 = strtotime ($pjesma_datum_vrijeme_kupnje);
                    $pjesma_datum_kupnje = date("d.m.Y H:i:s", $datum1);
                }

            echo "<tr><td>$pjesma_ime<br><br><audio controls><source src=$pjesma_link type='audio/mpeg'></audio></td>";
            echo "<td>$pjesma_opis</td><td>$datum_prikaz</td><td>$pjesma_datum_kupnje</td>";

  
            if (!empty($medijska_kuca_id) && !empty($pjesma_datum_vrijeme_kupnje)) {
                    $status = 'Pjesma je kupljena';
                    $uredenje_pjesme = '<p style="color: gray">Pjesmu više nije<br>moguće uređivati</p>';
                    echo "<td>$status</td>";
                    echo "<td>$uredenje_pjesme</td></tr>\n";
                } elseif (!empty($medijska_kuca_id) && empty($pjesma_datum_vrijeme_kupnje)) {
                    $status = 'Zatražena je kupnja pjesme';
                    $upravljanje_kupovinom = '<a href="action/prihvati_zahtjev.php?pjesma_id='. $pjesma_id . '"><button class="button-green">Prihvati</button></a>&nbsp;&nbsp;&nbsp;<a href="action/ukloni_zahtjev.php?pjesma_id='. $pjesma_id . '"><button class="button-red">Odbij</button></a>';
                    $uredenje_pjesme = '<a href="uredenje_pjesme.php?pjesma_id='. $pjesma_id . '"><button class="button-blue">Uredi pjesmu</button></a>';
                    echo "<td>$status<br><br>$upravljanje_kupovinom</td>";
                    echo "<td>$uredenje_pjesme</td></tr>\n";
                } else {
                    $status = 'Pjesma nije kupljena<br>ni zatražena';
                    $uredenje_pjesme = '<a href="uredenje_pjesme.php?pjesma_id='. $pjesma_id . '"><button class="button-blue">Uredi pjesmu</button></a>';
                    echo "<td>$status</td>";
                    echo "<td>$uredenje_pjesme</td></tr>\n";}
                }
                


    echo "</table>";    

	include("zajednicko/podnozje.php");
?>