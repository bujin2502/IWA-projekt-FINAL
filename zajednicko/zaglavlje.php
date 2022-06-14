<?php
	include("baza.php");
	if(session_id()=="")session_start();

	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;

	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_naziv=$_SESSION['aktivni_korisnik_naziv'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Glazbeni katalog</title>
		<meta name="autor" content="Zlatko Pračić"/>
		<meta name="datum" content="17.06.2022."/>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="public/stil.css">
	</head>
	<body>

		<header>
				<?php

					if($aktivni_korisnik===0){
						echo "<p><strong>Dobrodošli!</strong> Tip korisnika: <strong>neprijavljeni korisnik</strong></p>";
					}
					else{
						echo "<p>Dobrodošli <strong>$aktivni_korisnik_ime</strong>. Tip korisnika: <strong>$aktivni_korisnik_naziv</strong></p>";
					}
				?>
		</header>
			<?php
			echo "<ul>";
			echo "<li><a class='active' href='index.php'>Home</a></li>";
			if($aktivni_korisnik_tip==1 || $aktivni_korisnik_tip==2) {
				echo "<li><a href='moje_pjesme.php'>Moje pjesme</a></li>";
				echo "<li><a href='unos_pjesme.php'>Unos pjesme</a></li>";
			}
			if($aktivni_korisnik_tip==1) {
				echo "<li><a href='pjesme_kuca.php'>Zatražene i kupljene pjesme</a></li>";
			}
			if($aktivni_korisnik_tip==0) {
				echo "<li><a href='unos_kuce.php'>Medijska kuća</a></li>";
				echo "<li><a href='unos_korisnika.php'>Korisnici</a></li>";
			}
			echo "<li><a href='o_autoru.html'>O autoru</a></li>";
			if($aktivni_korisnik===0){
				echo "<li style='float:right'><a href='prijava.php'>Prijava</a></li>";
			} else {
				echo "<li style='float:right'><a href='action/odjava.php'>Odjava</a></li>";
			}
			echo "</ul>";
			?>