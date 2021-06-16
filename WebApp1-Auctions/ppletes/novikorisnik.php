<?php
$conn = new PDO('mysql:host=localhost; dbname=iwa_2017_zb_projekt','iwa_2017', 'foi2017'); 

mysql_connect('localhost','iwa_2017','foi2017');
mysql_select_db('iwa_2017_zb_projekt');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8"/>
	<title>AUKCIJE</title>
	<link 
		href="stil.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
</head>

<body>
<?php
include ('zaglavlje.php');
?>

<form method="post" action="novikorisnik.php"  enctype="multipart/form-data">

<center>
	<div class="lijevo">
	<div class="login">
  		<label for="ime">Ime</label>
	</div>
	<div>
  		<input type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite ime" name="ime" id="ime">	
	</div>
	<div class="login">
  		<label for="prezime">Prezime</label>
	</div>
	<div>
  		<input type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite prezime" name="prezime" id="prezime">	
	</div>
	<div class="login">
  		<label for="korisnicko_ime">Korisničko ime</label>
	</div>
	<div>
  		<input type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite korisničko ime" name="korisnicko_ime" id="korisnicko_ime">	
	</div>
	</div>
	<div class="desno">
	<div class="login">
  		<label for="email">E-mail</label>
	</div>
	<div>
  		<input type="email" style="height: 30px;font-size: 15px;text-align: center;" size="30%" placeholder="Unesite e-mail" class="labela" name="email" id="email">
	</div>	
	<div class="login">
  		<label for="lozinka">Lozinka</label>
	</div>
	<div>
  		<input type="password" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite lozinku" name="lozinka" id="lozinka">	
	</div>	
	<div class="login">
  		<label for="slika">Slika</label>
	</div>
	<div>
  		<input type="file" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" name="slika" id="slika">	
	</div>	
	</div>	
</center>	
<center>
	<div class="login">
	<button id="unesi" type="submit" class="gumb" name="unesi">Unesi</button>
	</div>
</center>

</form>

<?php  
if (isset($_POST['unesi'])) {
$ime=$_POST['ime'];
$prezime=$_POST['prezime'];
$korisnicko_ime=$_POST['korisnicko_ime'];
$email=$_POST['email'];
$lozinka=$_POST['lozinka'];
$slika=$_FILES['slika'];
$tip_id="2";

	if ($ime=="" or $prezime=="" or $korisnicko_ime=="" or $email="" or $lozinka=="" or $slika==""){
	
		echo "<script>alert('Niste unjeli sve podatke'); window.location='novikorisnik.php'</script>";
	
	}else{
		move_uploaded_file($_FILES["slika"],"uploads/" . $_FILES["slika"]);			


		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika) VALUES ('$tip_id','$korisnicko_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika')";
 
		$conn->exec($sql);
		echo "<script>alert('Uspiješno unesen korisnik'); window.location='korisnici.php'</script>";
	}
}


?>	
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>