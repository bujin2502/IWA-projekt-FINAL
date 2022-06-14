<?php
	include("zajednicko/zaglavlje.php");
	$bp=spojiSeNaBazu();
?>
<?php
	$greska= "";
	if(isset($_POST['submit'])){
		$kor_ime=$_POST['korisnicko_ime'];
		$lozinka=$_POST['lozinka'];

		if(!empty($kor_ime)&&!empty($lozinka)){
			$sql="SELECT k.tip_korisnika_id, k.ime, k.prezime, t.naziv, k.korisnik_id, k.medijska_kuca_id FROM korisnik k, tip_korisnika t, medijska_kuca mk WHERE t.tip_korisnika_id=k.tip_korisnika_id AND korime='$kor_ime' AND lozinka='$lozinka'";
			$rs=izvrsiUpit($bp,$sql);
			if(mysqli_num_rows($rs)==0) {
				$greska="Ne postoji korisnik s navedenim korisničkim imenom i lozinkom";
				}
				else{
				list($tip, $ime, $prezime, $naziv, $korisnik_id, $korisnik_medijska_kuca)=mysqli_fetch_array($rs);
				$_SESSION['aktivni_korisnik']=$kor_ime;
				$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
				$_SESSION['aktivni_korisnik_tip']=$tip;
				$_SESSION['aktivni_korisnik_naziv']=$naziv;
				$_SESSION['aktivni_korisnik_id']=$korisnik_id;
				if (!empty($korisnik_medijska_kuca)) {
					$_SESSION['aktivni_korisnik_medijska_kuca']=$korisnik_medijska_kuca;
				}
				header("Location:index.php");
			}
		} else {
			$greska = "Molim unesite korisničko ime i lozinku";
		}
	}
?>
<form class='forma' name="form" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
<h1 style="text-align:center">Prijava u sustav</h1>
<label for="korisnicko_ime">Korisničko ime: </label><br>
<input name="korisnicko_ime" id="korisnicko_ime" type="text" maxlength="50" size="70"/><br>
<label for="lozinka">Lozinka: </label><br>
<input name="lozinka"	id="lozinka" type="password" maxlength="50" size="70"/><br>
<button name="submit" type="submit">Prijavi se</button>
</form>

<h1 class="upozorenje"><?php if($greska!="")echo $greska; ?></h1>

<?php
	zatvoriVezuNaBazu($bp);
	include("zajednicko/podnozje.php");
?>