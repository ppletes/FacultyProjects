<header>
<style>
a.naslov{
	color: black;
}
a.naslov:hover {
	color: white;
}
</style>
		<link 
		href="stil.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
		/>	
	<div class="naslov">
		<a onclick="poruka()" class="naslov" id="naslov" style="text-decoration: none;">
			AUKCIJE_hr
		</a>
<script>
function poruka() {
    var upitnik = confirm("Da li ste sigurni da želite napustiti ovu stranicu");
    if (upitnik == true) {
        document.location.href='index.php';
    } else {
        alert("Odustali ste od preusmjeravanja");
    }
    document.getElementById("demo").innerHTML = txt;
}
</script>		
	</div>
	
	<nav class="veza">
	<?php session_start();if(!isset($_SESSION['korisnikpodaci'])){ ?>
		<a class="veza" target="_blank" style="float: right; margin-right: 20px; margin-top: -40px;" href="o_autoru.html">O autoru</a>
		<a class="veza" href="registracija.php">
			Registracija
		</a> <br>
		<a name="prijava" class="veza" href="prijava.php">
			Prijava
		</a> 
	<?php } else { ?>
		<a class="veza" href="odjava.php">
			Odjava
		</a> 
	<?php } ?>
		<?php
		
    if (isset($_POST['log'])){   	
    $korisnicko_ime=$_POST['korisnicko_ime'];
    $lozinka=$_POST['lozinka'];
	$query = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime='$korisnicko_ime' AND lozinka='$lozinka'");
	
	$row=mysql_fetch_assoc($query);
	$_SESSION['korisnik_id']= $row['korisnik_id'];  
	
	$_SESSION['tip_id']=$row['tip_id'];
	
	$korisniktip=mysql_num_rows($query);
	if($korisniktip==1) $_SESSION['korisniktip']=$korisniktip;

	
	$korisnikpodaci=mysql_num_rows($query);
	if($korisnikpodaci==1) $_SESSION['korisnikpodaci']=$korisnikpodaci;
	
		if ($korisnikpodaci==0){
			echo "<script type='text/javascript'>alert('Korisničko ime ili lozinka nije ispravno')</script>";
			echo "<script language='javascript' type='text/javascript'> location.href='prijava.php' </script>"; 
		}else{
			echo "<script type='text/javascript'>alert('Uspiješno ste prijavljeni pod imenom $korisnicko_ime')</script>";
			echo "<script language='javascript' type='text/javascript'> location.href='moje_aukcije.php' </script>"; 
		}			
	}


if(!isset($_SESSION['korisnikpodaci'])){ 
	echo "<style type=\"text/css\">#korisnici{display:none;}</style>";
	echo "<style type=\"text/css\">#moje_aukcije{display:none;}</style>";
	echo "<style type=\"text/css\">#gumbici{display:none;}</style>";
	echo "<style type=\"text/css\">#upit{float:right;margin-right: 30px;margin-top: 10px;}</style>";
	echo "<style type=\"text/css\">#uredipredmet{display:none;}</style>";
	echo "<style type=\"text/css\">#ponuda{display:none;}</style>";
	echo "<style type=\"text/css\">#obrisii{display:none;}</style>";
	echo "<style type=\"text/css\">#unesipred{display:none;}</style>";
	echo "<style type=\"text/css\">#checkbox{display:none;}</style>";
	echo "<style type=\"text/css\">#opis{visibility: hidden;}</style>";
	echo "<style type=\"text/css\">#prodki{visibility: hidden;}</style>";
	echo "<style type=\"text/css\">#ad{display: none;}</style>";
	echo "<style type=\"text/css\">#brojkupca{display:none;}</style>";
	echo "<style type=\"text/css\">#pocetnacijena{visibility: hidden;}</style>";
	echo "<style type=\"text/css\">#najvecaponuda{margin-left:-630px;}</style>";
	echo "<style type=\"text/css\">#slikicka{margin-left: 300px;}</style>";
	echo "<style type=\"text/css\">#ime{margin-left: 400px;}</style>";
}

if(isset($_SESSION['korisnikpodaci'])){ 
	$_SESSION['tip_id'];
		if($_SESSION['tip_id']=='0'){
			echo "<style type=\"text/css\">#zatvoriaukciju{display:none;}</style>";			
			echo "<style type=\"text/css\">#gumbici{display: inline;}</style>";			
			echo "<style type=\"text/css\">#upit{float:right;margin-right: 30px;margin-top: 10px;}</style>";		
			echo "<style type=\"text/css\">#modrazmak{display: none;}</style>";	
			echo "<style type=\"text/css\">#uredipredmet{display: none;}</style>";				
		}elseif($_SESSION['tip_id']=='1'){
			echo "<style type=\"text/css\">#broj_prodavaca{display:none;}</style>";
			echo "<style type=\"text/css\">#korisnici{display:none;}</style>";
			echo "<style type=\"text/css\">#unesiauk{display:none;}</style>";
			echo "<style type=\"text/css\">#gumbici{display:inline;}</style>";
			echo "<style type=\"text/css\">#upit{float:right;margin-right: 30px;margin-top: 10px;}</style>";
			echo "<style type=\"text/css\">#uredipredmet{display:none;}</style>";
			echo "<style type=\"text/css\">#obrisii{display:none;}</style>";
			echo "<style type=\"text/css\">#obrisi{display:none;}</style>";
			echo "<style type=\"text/css\">#nazivaukcijice{display:none;}</style>";		
			echo "<style type=\"text/css\">#razmak{display:none;}</style>";		
			echo "<style type=\"text/css\">#ad{display: none;}</style>";
			echo "<style type=\"text/css\">#zatvoriaukciju{display:none;}</style>";		
		}elseif ($_SESSION['tip_id']=='2'){
			echo "<style type=\"text/css\">#korisnici{display:none;}</style>";
			echo "<style type=\"text/css\">#gumbici{display:none;}</style>";
			echo "<style type=\"text/css\">#upit{float:right;margin-right: 30px;margin-top: 10px;}</style>";
			echo "<style type=\"text/css\">#uredipredmet{display:none;}</style>";
			echo "<style type=\"text/css\">#obrisii{display:none;}</style>";
			echo "<style type=\"text/css\">#najvecaponuda{display:none;}</style>";
			echo "<style type=\"text/css\">#ad{display: none;}</style>";
			echo "<style type=\"text/css\">#broj_prodavaca{display:none;}</style>";
			echo "<style type=\"text/css\">#moderator_aukcije{display:none;}</style>";
		}
}
    ?>
		
		
	</nav>
	</header>	
	<hr>	
	<div class="meni1">
		<ul>
		<center>
			<li><a href="pocetna.php">POČETNA</a></li>
			<li><a href="pretrazi.php">PRETRAŽI</a></li>
			<li><a href="info.php">O NAMA</a></li>
			<li id="moje_aukcije"><a href="moje_aukcije.php">MOJE AUKCIJE</a></li>
			<li id="korisnici"><a href="korisnici.php">KORISNICI</a></li>
		</center>
		</ul>
	</div>
	<hr>
	
		
