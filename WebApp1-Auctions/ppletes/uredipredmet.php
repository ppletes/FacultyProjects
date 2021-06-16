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

$id=$_SESSION['predmet_id'];
$sql=("SELECT * FROM predmet WHERE predmet_id='$id'");
$result=mysql_query($sql);
while($rows=mysql_fetch_array($result)){  
?>
<form method="post" action="uredipredmet.php">
<button type="submit" style="margin-left: 85px; width: 200px;" name="odustani" id="odustani" class="unesi" type="submit">Odustani</button><?php if(isset($_POST['odustani'])){header ("Location: predmeti.php");} ?>
<button style="margin-left: 40px; width: 200px;" name="uredipredmet" id="uredipredmet" class="unesi" type="submit">Uredi</button>
<hr>
<br>
<div style="margin-left: 30px;">
<label>Naziv</label><br>
<input type="text" value="<?php echo $rows['naziv']; ?>" size="40%" name="naziv" id="naziv" style="text-align: center; height: 30px;">
</div><br>

<div style="margin-left: 30px;">
<label>URL do fotografije na web-u</label><br>
<input type="URL" name="url" id="url" value="<?php echo $rows['slika']; ?>" size="40%" style="text-align: center; height: 30px; width: 250px;">
</div><br>

<div style="margin-left: 30px;">
<label>Početna cijena (HRK)</label><br>
<input type="number_format" value="<?php echo $rows['pocetna_cijena']; ?>" name="pocetna_cijena" id="pocetna_cijena" size="40%" style="text-align: center; height: 30px; width: 200px;">
</div><br>

<div style="margin-left: 400px; margin-top: -247px;">
<label>Opis</label><br>
<textarea style="resize: none;" rows="13" cols="50" name="opis" id="opis"><?php echo $rows['opis']; ?></textarea>
</div><br>


<image src="http://www.newmeis.com/new.png" style="margin-top: -250px; margin-left: 855px; transform: rotate(35deg);" height="300" width="350" class="slikaPocetna"/>
</form>
<?php  
}
if(isset($_POST['uredipredmet']))
{

$url=$_POST['url'];
$naziv=$_POST['naziv'];
$opis=$_POST['opis'];
$pocetna_cijena=$_POST['pocetna_cijena'];
$id=$_SESSION['predmet_id'];

mysql_query("UPDATE predmet SET slika ='$url', naziv='$naziv',
opis='$opis',pocetna_cijena ='$pocetna_cijena' WHERE predmet_id='$id'")
or die(mysql_error());
$_SESSION['uredipredmet']="Predmet uspiješno uređen";
echo "<script>alert('Uspiješno uređen predmet'); window.location='predmeti.php' </script>";

}
mysql_close();
?>	
<br>

</body>

<footer style="margin-top: -30px;">
<?php
include ('podnozje.php');
?>
</footer>
</html>