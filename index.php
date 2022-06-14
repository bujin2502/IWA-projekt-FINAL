<?php
	include("zajednicko/zaglavlje.php");

	switch ($aktivni_korisnik_tip) {
		case(-1): include("views/view_anon.php");
		break;
		case(0): include("views/view_admin.php");
		break;
		case(1): include("views/view_mod.php");
		break;
		case(2): include("views/view_kor.php");
		break;
	};

	include("zajednicko/podnozje.php");
?>