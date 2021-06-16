<?php
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

<form action = "" method = "post">
<center>
<div class="logireg">

	<div class="login">
  		<label for="korisnicko_ime">Korisničko ime</label>
	</div>
	<div>
  		<input type="text" style="height: 30px;font-size: 15px;text-align: center;" size="30%" class="labela" placeholder="Unesite korisničko ime" name="korisnicko_ime" id="korisnicko_ime">	
	</div>
	<div class="login">
  		<label for="lozinka">Lozinka</label>
	</div>
	<div>
  		<input type="password" style="height: 30px;font-size: 15px;text-align: center;" size="30%" placeholder="Unesite lozinku" class="labela" name="lozinka" id="lozinka">
	</div>	
</center>
	<center>
	<div class="login">
	<button type="submit" class="gumb" name="log">Prijava</button>
  	<p style="font-size:20px">
  		Niste član? <a href="registracija.php">Registrirajte se</a>
  	</p>
	</div>
	</center>
</div>
</form>
	<br><br><br><br><br>
	<pre class="slova1">Prijavite se kako bi lakše pretraživali, kupovali i prodavali.</pre>
	<pre class="slova2">Postanite dio našeg tima!</pre>
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>