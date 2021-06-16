<?php
$conn = new PDO('mysql:host=localhost; dbname=iwa_2017_zb_projekt','iwa_2017', 'foi2017');      
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

<form method="post" action="registracija.php"  enctype="multipart/form-data">

<center>
	<div class="lijevo">
	<div class="login">
  		<label for="ime">Ime</label>
	</div>
	<div>
  		<input type="text" style="margin-left: -5px;height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite ime" name="ime" id="ime">	
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
	
	<button id="gumb" type="submit" class="gumb" name="reg">Registrirajte se</button>
	
  	<p style="font-size:20px;">
  		Već ste član? <a href="prijava.php">Prijavite se</a>
  	</p>
	</div>
</center>

</form>

	<br><br><br><br><br>
	<pre class="slova1">Registrirajte se kako bi lakše pretraživali, kupovali i prodavali.</pre>
	<pre class="slova2">Postanite dio našeg tima!</pre>

<?php  

if (isset($_POST['reg'])) {
$ime=$_POST['ime'];
$prezime=$_POST['prezime'];
$korisnicko_ime=$_POST['korisnicko_ime'];
$email=$_POST['email'];
$lozinka=$_POST['lozinka'];

$slika = "korisnici/";
$slika = $slika . basename( $_FILES['slika']);

$tip_id="2";
	if ($ime=="" or $prezime=="" or $korisnicko_ime=="" or $email="" or $lozinka=="" or $slika==""){
	
		echo "<script>alert('Niste unjeli sve podatke'); window.location='registracija.php'</script>";
	
	}else{
	$servername = "localhost";
	$username = "iwa_2017";
	$password = "foi2017";
	$dbname = "iwa_2017_zb_projekt";

	try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		move_uploaded_file($_FILES["slika"],"updates/" . $_FILES["slika"]);		
    $sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
		VALUES ('$tip_id','$korisnicko_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika')";
 
		$conn->exec($sql);
		echo "<script>alert('Uspiješno ste registrirani'); window.location='prijava.php'</script>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
	
}}
?>	

</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>