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

$id=$_SESSION['korisnik_id'];
$sql=("SELECT * FROM korisnik WHERE korisnik_id='$id'");
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result)){  
?>

<form method="post" action="uredikorisnik.php"  enctype="multipart/form-data">
<br>
<center>	
	<label style="align: center; margin-top: -200px;">Tip</label>
	<input value="<?php echo $rows['tip_id']; ?>" type="text" style="height: 30px;font-size: 15px;text-align: center;" size="5%" class="labela" name="tip_id" id="tip_id">
</center>
<center>
	
	<div class="lijevo">
	<div class="login">
  		<label for="ime">Ime</label>
	</div>
	<div>
  		<input value="<?php echo $rows['ime']; ?>" type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite ime" name="ime" id="ime">	
	</div>
	<div class="login">
  		<label for="prezime">Prezime</label>
	</div>
	<div>
  		<input value="<?php echo $rows['prezime']; ?>" type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite prezime" name="prezime" id="prezime">	
	</div>
	<div class="login">
  		<label for="korisnicko_ime">Korisničko ime</label>
	</div>
	<div>
  		<input value="<?php echo $rows['korisnicko_ime']; ?>" type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite korisničko ime" name="korisnicko_ime" id="korisnicko_ime">	
	</div>
	</div>
	<div class="desno">
	<div class="login">
  		<label for="email">E-mail</label>
	</div>
	<div>
  		<input value="<?php echo $rows['email']; ?>" type="email" style="height: 30px;font-size: 15px;text-align: center;" size="30%" placeholder="Unesite e-mail" class="labela" name="email" id="email">
	</div>	
	<div class="login">
  		<label for="lozinka">Lozinka</label>
	</div>
	<div>
  		<input value="<?php echo $rows['lozinka']; ?>" type="password" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite lozinku" name="lozinka" id="lozinka">	
	</div>	
	<div class="login">
  		<label for="slika">Slika</label>
	</div>
	<div>
  		<input value="<?php echo $rows['slika']; ?>" type="file" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" name="slika" id="slika">	
	</div>	
	</div>	
</center>	
<center>
	<div class="login">
	<button id="uredi" type="submit" class="gumb" name="uredi">Uredi</button>
	</div>
</center>

</form>

<?php  
}
if(isset($_POST['uredi']))
{
$ime_uredi = $_POST['ime'];
$prezime_uredi = $_POST['prezime'];
$korisnicko_ime_uredi = $_POST['korisnicko_ime'];
$email_uredi = $_POST['email'];
$lozinka_uredi = $_POST['lozinka'];
$slika_uredi = $_FILES['slika'];
$tip_id=$_POST['tip_id'];

mysql_query("UPDATE korisnik SET tip_id='$tip_id', ime ='$ime_uredi', prezime='$prezime_uredi',
korisnicko_ime='$korisnicko_ime_uredi',email ='$email_uredi',lozinka ='$lozinka_uredi',slika ='$slika_uredi' WHERE korisnik_id = '$id'")
or die(mysql_error());
$_SESSION['uredi']="Korisnik uspiješno uređen";
echo "<script>alert('Uspiješno uređen korisnik'); window.location='korisnici.php'</script>";

}
mysql_close();
?>	
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>