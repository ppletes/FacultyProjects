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

$id=$_SESSION['aukcija_id'];
$sql=("SELECT *,korisnik.korisnik_id,korisnik.tip_id FROM aukcija INNER JOIN korisnik ON korisnik.korisnik_id=moderator_id WHERE aukcija_id='$id' AND tip_id='1'");
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){  
?>
<form method="post" action="uredi_aukcija.php"  enctype="multipart/form-data">

<button type="submit" style="margin-left: 85px; width: 200px;" name="odustani" id="odustani" class="unesi" type="submit">Odustani</button><?php if(isset($_POST['odustani'])){header ("Location: pretrazi.php");} ?>
<button style="margin-left: 80px; width: 200px;" id="urediaukciju" type="submit" class="unesi" name="urediaukciju">Uredi aukciju</button>
<hr>
<br id="modrazmak"><br id="modrazmak"> 

<div style="text-align: center; margin-left: -100px;">
<div id="zamoderatora"style="margin-left: 150px"><label>DATUM ZAVRŠETKA</label>
<input id="zavrsetak" name="zavrsetak" placeholder="dd.mm.gggg hh:mm:ss" style="text-align: center; height: 30px; width: 250px; margin-left: 30px;" value="<?php $datummm=$row['datum_vrijeme_zavrsetka']; $formatdatummm = date("d.m.Y H:m:s", strtotime($datummm)); echo $formatdatummm; ?>" size="40%" type="text"></div><br><br><br>
<div style="margin-left: -300px;">
<label id="nazivaukcijice">Naziv</label><br>
<input id="nazivaukcijice" type="text" value="<?php echo $row['naziv']; ?>" size="40%" name="naziv" id="naziv" style="text-align: center; height: 30px;">
</div><br>

<div id="nazivaukcijice" style="margin-left: -300px;">
<label id="nazivaukcijice">Datum i vrijeme početka</label><br>
<input id="datum_vrijeme_pocetka" placeholder="dd.mm.gggg hh:mm:ss" type="text" value="<?php $datumm=$row['datum_vrijeme_pocetka']; $formatdatumm = date("d.m.Y H:m:s", strtotime($datumm)); echo $formatdatumm; ?>" name="datum_vrijeme_pocetka" size="40%" style="text-align: center; height: 30px; width: 250px;">
</div><br>

<div id="nazivaukcijice" style="margin-left: -300px;">
<label>Moderator</label><br>
<?php 
echo "<select placeholder='Odaberite moderatora aukcije' name='moderator' id='moderator' style=\"width: 200px; height: 33px;\">"; ?>
<option value="<?php echo $row['moderator_id'].' | '.$row['ime'].' '.$row['prezime']; ?>"><?php echo $row['korisnik_id'].' | '.$row['ime'].' '.$row['prezime']; ?></option> 
</select>
</div><br>

<div id="nazivaukcijice" style="margin-left: 500px; margin-top: -233px;">
<label>Opis</label><br>
<textarea style="resize: none;" rows="13" cols="50" name="opis" id="opis"><?php echo $row['opis']; ?></textarea>
</div><br>

</div id="razmak">

<br id="razmak">
</form>
<?php  
}
if(isset($_POST['urediaukciju']))
{
$naziv = $_POST['naziv'];
$opis = $_POST['opis'];
$datum_vrijeme_pocetka= $_POST['datum_vrijeme_pocetka'];
$de= date("Y-m-d H:m:s", strtotime($datum_vrijeme_pocetka));
$moderator = $_POST['moderator'];
$zavrsetak=$_POST['zavrsetak'];
$do= date("Y-m-d H:m:s", strtotime($zavrsetak));

if(preg_match("/^[a-z]$/i", $datum_vrijeme_pocetka) or preg_match("/^(0|[1-9][0-9]*)$/i", $datum_vrijeme_pocetka) or preg_match("/^[a-z]$/i", $zavrsetak) or preg_match("/^(0|[1-9][0-9]*)$/i", $zavrsetak)){	
	echo "<script>alert('Niste unjeli ispravan datum'); window.location= 'uredi_aukcija.php';</script>";
}else{

mysql_query("UPDATE aukcija SET naziv ='$naziv', opis='$opis',
datum_vrijeme_pocetka='$de',datum_vrijeme_zavrsetka='$do',moderator_id ='$moderator' WHERE aukcija_id = '$id'")
or die(mysql_error());
$_SESSION['urediaukciju']="Aukcija uspiješno uređena";
echo "<script>alert('Uspiješno uređena aukcija'); window.location='pretrazi.php' </script>";

}}
mysql_close();
?>	
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>