<?php
	define("SERVER","localhost");
	define("BAZA","iwa_2021_vz_projekt");
	define("BAZA_KORISNIK","iwa_2021");
	define("BAZA_LOZINKA","foi2021");
	define("ZNAKOVI","utf8");

	function spojiSeNaBazu(){
		$veza=mysqli_connect(SERVER,BAZA_KORISNIK,BAZA_LOZINKA,BAZA);
		if(!$veza)echo "GREŠKA: Problem sa spajanjem u datoteci baza.php funkcija spojiSeNaBazu: ".mysqli_connect_error();
		mysqli_set_charset($veza,ZNAKOVI);
		if(mysqli_error($veza)!=="")echo "GREŠKA: Problem sa postavljanjem kodnog sustava u baza.php funkcija spojiSeNaBazu: ".mysqli_error($veza);
		return $veza;
	}

	function izvrsiUpit($veza,$upit){
		$rezultat=mysqli_query($veza,$upit);
		if(mysqli_error($veza)!=="")echo "GREŠKA: Problem sa upitom: ".$upit." : u datoteci baza.php funkcija izvrsiUpit: ".mysqli_error($veza);
		return $rezultat;
	}

	function zatvoriVezuNaBazu($veza){
		mysqli_close($veza);
	}
?>