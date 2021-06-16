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

$sql=mysql_query("SELECT korisnik_id,ime,prezime,tip_id FROM korisnik WHERE tip_id='1'");

?>
<form method="post" action="nova_aukcija.php">
<button type="submit" style="margin-left: 85px; width: 200px;" name="odustani" id="odustani" class="unesi" type="submit">Odustani</button><?php if(isset($_POST['odustani'])){header ("Location: pretrazi.php");} ?>
<button style="margin-left: 40px; width: 200px;" name="unesi" id="unesi" class="unesi" type="submit">Unesi</button>
<hr>
<br><br>
<div style="margin-left: 30px;">
<label>Naziv</label><br>
<input type="text" placeholder="Unesite puni naziv aukcije" size="40%" name="naziv" id="naziv" style="text-align: center; height: 30px;">
</div><br>

<div style="margin-left: 30px;">
<label>Datum i vrijeme početka</label><br>
<input type="text" placeholder="dd-mm-gggg hh:mm:ss" name="datum_vrijeme_pocetka" id="datum_vrijeme_pocetka" size="40%" style="text-align: center; height: 30px; width: 250px;">
</div><br>

<div style="margin-left: 30px;">
<label>Moderator</label><br>
<?php 
echo "<select placeholder='Odaberite moderatora aukcije' name='moderator' id='moderator' style=\"width: 200px; height: 33px;\">";
while ($moderat=mysql_fetch_assoc($sql)) { ?>
<option value=" <?php echo $moderat['korisnik_id'].' | '.$moderat['ime'].' '.$moderat['prezime']; ?>"><?php echo $moderat['korisnik_id'].' | '.$moderat['ime'].' '.$moderat['prezime']; ?></option>  
<?php }
echo "</select>"; ?></div><br>

<div style="margin-left: 400px; margin-top: -247px;">
<label>Opis</label><br>
<textarea style="resize: none;" rows="13" cols="50" name="opis" id="opis" placeholder="Opišite aukciju"></textarea>
</div><br>


<image src="http://www.newmeis.com/new.png" style="margin-top: -250px; margin-left: 860px; transform: rotate(35deg);" height="300" width="350" class="slikaPocetna"/>
</form>
<?php
if (isset($_POST['unesi'])){
	$moderator_id=$_POST['moderator'];
	$naziv=$_POST['naziv'];
	$opis=$_POST['opis'];
	$datum_vrijeme_pocetka= $_POST['datum_vrijeme_pocetka'];
	$da= date('Y-m-d H:m:s', strtotime($_POST['datum_vrijeme_pocetka']));

	
if(preg_match("/^[a-z]$/i", $datum_vrijeme_pocetka) or preg_match("/^(0|[1-9][0-9]*)$/i", $datum_vrijeme_pocetka)){	
	echo "<script>alert('Niste unjeli ispravan datum'); window.location= 'nova_aukcija.php';</script>";
}else{
	if ($moderator_id=="" or $naziv=="" or $opis=="" or $datum_vrijeme_pocetka==""){
		echo "<script>alert('Niste unjeli sve podatke'); window.location= 'nova_aukcija.php';</script>";
	}else{
$servername = "localhost";
$username = "iwa_2017";
$password = "foi2017";
$dbname = "iwa_2017_zb_projekt";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $aukcija = "INSERT INTO aukcija (moderator_id, naziv, opis, datum_vrijeme_pocetka)
    VALUES ('$moderator_id', '$naziv', '$opis', '$da')";
    $conn->exec($aukcija);
    echo "<script>alert('Uspiješno ste unjeli aukciju'); window.location= 'pretrazi.php';</script>";
    }
catch(PDOException $e)
    {
    echo $aukcija . "<br>" . $e->getMessage();
    }

$conn = null;
} }
 }
?>
<br>

</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>