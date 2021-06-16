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
<form method="post" action="novipredmet.php">
<button type="submit" style="margin-left: 85px; width: 200px;" name="odustani" id="odustani" class="unesi" type="submit">Odustani</button><?php if(isset($_POST['odustani'])){header ("Location: predmeti.php");} ?>
<button style="margin-left: 40px; width: 200px;" name="unesipred" id="unesipred" class="unesi" type="submit">Unesi</button>
<hr>
<br>
<div style="margin-left: 30px;">
<label>Naziv</label><br>
<input type="text" placeholder="Unesite puni naziv predmeta" size="40%" name="naziv" id="naziv" style="text-align: center; height: 30px;">
</div><br>

<div style="margin-left: 30px;">
<label>URL do fotografije na web-u</label><br>
<input type="URL" name="url" placeholder="Unesite URL Vaše fotogarfije na Web-u" id="url" size="40%" style="text-align: center; height: 30px; width: 250px;">
</div><br>

<div style="margin-left: 30px;">
<label>Početna cijena (HRK)</label><br>
<input type="number_format" placeholder="Unesite cijenu (broj)" name="pocetna_cijena" id="pocetna_cijena" size="40%" style="text-align: center; height: 30px; width: 200px;">
</div><br>

<div style="margin-left: 400px; margin-top: -247px;">
<label>Opis</label><br>
<textarea style="resize: none; font-family: Arial;" rows="13" cols="50" name="opis" id="opis" placeholder="Opišite predmet"></textarea>
</div><br>


<image src="http://www.newmeis.com/new.png" style="margin-top: -250px; margin-left: 855px; transform: rotate(35deg);" height="300" width="350" class="slikaPocetna"/>
</form>
<?php
if (isset($_POST['unesipred'])){

	$url=$_POST['url'];
	$naziv=$_POST['naziv'];
	$opis=$_POST['opis'];
	$pocetna_cijena=$_POST['pocetna_cijena'];
	$korisnik_id=$_SESSION['korisnik_id'];
	$id=$_SESSION['aukcija_id'];
	
	
	if ($url=="" or $naziv=="" or $opis=="" or $pocetna_cijena==""){
		echo "<script>alert('Niste unjeli sve podatke'); window.location= 'novipredmet.php';</script>";
	}else{
$servername = "localhost";
$username = "iwa_2017";
$password = "foi2017";
$dbname = "iwa_2017_zb_projekt";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $aukcija = "INSERT INTO predmet (aukcija_id, korisnik_id, naziv, opis, slika, pocetna_cijena)
    VALUES ('$id', '$korisnik_id', '$naziv', '$opis', '$url', '$pocetna_cijena')";
    $conn->exec($aukcija);
    echo "<script>alert('Uspiješno ste unjeli predmet'); window.location= 'predmeti.php';</script>";
    }
catch(PDOException $e)
    {
    echo $aukcija . "<br>" . $e->getMessage();
    }

$conn = null;
} }
?>
<br>

</body>

<footer style="margin-top: -30px;">
<?php
include ('podnozje.php');
?>
</footer>
</html>