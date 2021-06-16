<?php
header('Content-type: text/html; charset=UTF-8');  
$conn=mysqli_connect("localhost", "iwa_2018", "foi2018", "iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8"/>
	<title>KORISNIČKA PODRŠKA</title>
	<link 
		href="style.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
	<link 
		href="stylezagpod.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>
</head>

<body>
<div class="crno"><br></div>
<center><div class="kocka"><div class="tijelo">
<br>
<div class="logo1">
	<a class="logo2" onclick="poruka()" style="text-decoration: none;">KP.hr</a>
	<br>
	<a class="autor" href="o_autoru.html" style="text-decoration: none;">O autoru</a>

	<script>
		function poruka() {
			var upitnik = confirm("Želite li napustiti stranicu?");
			if (upitnik == true) {
				document.location.href='index.php';
			} else {
				alert("Preusmjeravanje neuspiješno.");
			}
			document.getElementById("demo").innerHTML = txt;
		}
	</script>

	
</div>
<div style="float: right; margin-right: 1%; margin-top: 2%;">
	<nav>
	<?php session_start();
		if(!isset($_SESSION['sesija_podaci'])){ 	echo "<style type=\"text/css\">#pocetna_tablica{display:none;}</style>"; ?>
			<a class="reg-pri" href="reg_pri.php">PRIJAVA</a>
	<?php } else { 
				$queryy=mysqli_query($conn,"SELECT zaposlenik.korisnik_id, korisnik.korisnik_id, tvrtka_id, zaposlenik_id, korisnik.tip_id 
											FROM zaposlenik INNER JOIN korisnik ON korisnik.korisnik_id=zaposlenik.korisnik_id");
				while($roww=mysqli_fetch_assoc($queryy)){
				
				$kor=$roww['korisnik_id'];
				$id_tvr=$roww['tvrtka_id'];
				$tip=$roww['tip_id'];
				
				if($_SESSION['korisnik_id']==$kor){ 						
						
				if($queryy_odg=mysqli_query($conn,"SELECT tvrtka_id, preostaliOdgovori FROM tvrtka WHERE tvrtka_id='$id_tvr'")){
					while($row_odg=mysqli_fetch_array($queryy_odg)){ ?>

					<a class="reg-pri"><?php echo "Broj odgovora: " . $row_odg['preostaliOdgovori']; ?></a>
					<?php } } ?>
				<br>
	<?php } } ?> 
			
				<a class="reg-pri" href="odjava.php">
					Odjava
				</a> 
			
			
	<?php } 
		if (isset($_POST['prijava'])){   	
			$korisnicko_ime=$_POST['korisnicko_ime'];
			$lozinka=$_POST['lozinka'];
			
			$sql_prijava = mysqli_query($conn,"SELECT * FROM korisnik WHERE korisnicko_ime = '$korisnicko_ime' AND lozinka='$lozinka'");
			$row_prijava=mysqli_fetch_assoc($sql_prijava);
	
			$_SESSION['korisnik_id'] = $row_prijava['korisnik_id'];  
			$_SESSION['tip_id'] = $row_prijava['tip_id'];
				
			$sesija=mysqli_num_rows($sql_prijava);
			if($sesija==1){ 
				$_SESSION['sesija']=$sesija;
			}
	
			$sesija_podaci=mysqli_num_rows($sql_prijava);
			if($sesija_podaci==1){ 
				$_SESSION['sesija_podaci']=$sesija_podaci;
			}
		
			if ($sesija_podaci==0){
				echo "<script type='text/javascript'>alert('Korisničko ime ili lozinka nije ispravno.'); window.location='reg_pri.php';</script>";
			}else{
				echo "<script type='text/javascript'>alert('Uspiješno ste prijavljeni pod imenom $korisnicko_ime'); window.location='pocetak.php';</script>";
			}
		}		
	?>
	</nav>
</div>
<br><br><br><br><br>
<ul class="meni_pozadina"> 
	<li><a class="trenutno" href="pocetak.php">POČETNA</a></li>
	<li><a href="tvrtka.php">TVRTKA</a></li>
	<li><a href="onama.php">O NAMA</a></li>
	
	<li id="meni_admin" style="float: right;"><a href="azuriraj.php">AŽURIRAJ</a></li>
	<li id="meni_moderator" style="float: right;"><a href="zaposlenici.php">ZAPOSLENICI</a></li>
	<li id="meni_moderator" style="float: right;"><a href="moja_tvrtka.php">MOJA TVRTKA</a></li>
</ul>

<?php 
if(!isset($_SESSION['sesija_podaci'])){
	echo "<style type=\"text/css\">#meni_moderator{display:none;}</style>";
	echo "<style type=\"text/css\">#meni_admin{display:none;}</style>";
	echo "<style type=\"text/css\">.statistika_admin{display:none;}</style>";
	echo "<style type=\"text/css\">#tvrtka_anonim{display:none;}</style>";
	echo "<style type=\"text/css\">#obrazac_oznaci{display:none;}</style>";
}elseif(isset($_SESSION['sesija_podaci'])){
	$_SESSION['tip_id'];
	if($_SESSION['tip_id']=='2'){
		echo "<style type=\"text/css\">#meni_moderator{display:none;}</style>";		
		echo "<style type=\"text/css\">#meni_admin{display:none;}</style>";		
		echo "<style type=\"text/css\">.statistika_admin{display:none;}</style>";	
		echo "<style type=\"text/css\">#tvrtka_anonim{display:none;}</style>";		
	}
	if($_SESSION['tip_id']=='1'){
		echo "<style type=\"text/css\">#meni_admin{display:none;}</style>";				
		echo "<style type=\"text/css\">.statistika_admin{display:none;}</style>";
	}
}
?>


</div></div></center>
</body>
</html>