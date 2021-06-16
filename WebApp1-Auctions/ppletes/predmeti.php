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
<form method="post" action="" style="font-family: Times New Roman, Times, serif; size: large;">

<input style="margin-left: 85px; width: 200px;" name="unesipred" id="unesipred" class="unesi" type="submit" Value="Unesi novi predmet">
<input style="margin-left: 80px; width: 150px;" id="uredipredmet" type="submit" class="unesi" name="uredipredmet" Value="Uredi predmet">
<input style="margin-left: 85px; width: 150px;" class="unesi" type="submit" id="ponuda" name="ponuda" value="Ponuda"> 
<input style="margin-left: 85px; width: 150px;" id="obrisii" type="submit" class="unesi" name="obrisii" Value="Obriši">
<input type="submit" style="width: 30px; height: 23px; margin-left: 90px;" id="upit" name="upit" value="?" target="_blank" onclick="window.open('predmeti_opis.html')" />

<hr>
<?php 
$idauk=$_SESSION['aukcija_id'];
$sql=mysql_query("SELECT predmet.predmet_id,predmet.slika,predmet.naziv,predmet.opis,predmet.pocetna_cijena,predmet.korisnik_id,korisnik.korisnik_id,korisnik.ime,korisnik.prezime FROM predmet INNER JOIN korisnik ON predmet.korisnik_id=korisnik.korisnik_id WHERE aukcija_id='$idauk'");

if (isset($_POST['unesipred'])){ 
	header("Location: novipredmet.php");
}
while($predmet=mysql_fetch_array($sql)){ $idpredmet=$predmet['predmet_id'];

 
		
if(isset($_POST['uredipredmet'])){
	for($i=1;$i>count($_POST['checkbox']);$i++){
		echo header ("Location: predmeti.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
		$id=$_POST['checkbox'][$i];
		$_SESSION['predmet_id']=$id;
		header("Location: uredipredmet.php");
	}
}

		
if (isset($_POST['obrisii'])){
$checkbox = $_POST['checkbox'];
for($i=1;$i>count($checkbox);$i++){
header("Location: predmeti.php"); }
for($i=0;$i<count($checkbox);$i++){
$del_id = $checkbox[$i]; 
mysql_query("DELETE FROM `iwa_2017_zb_projekt`.`predmet` WHERE `predmet`.`predmet_id` = '$del_id'");
echo "<script>alert ('Predmet je uspiješno obrisan'); window.location= 'predmeti.php';</script>";
}
}		
		
if(isset($_POST['ponuda'])){
	for($i=1;$i>count($_POST['checkbox']);$i++){
		echo header ("Location: predmeti.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
		$id=$_POST['checkbox'][$i];
		$_SESSION['predmet_id']=$id;
		echo header ("Location: ponuda.php");
	}	
}

?>
<center>	
		<div id="slikicka" style="margin-right: 1000px; margin-top: 70px; height: 25px; width: 100px; text-align: center;"><?php echo "<img src=".$predmet['slika']." width=\"300\"height=\"300\" onclick=\"window.open(this.src, '_blank', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');\">";?></div>
		<div id="prodki" style="margin-left: 430px; margin-top: 30px; display: inline-block; height: 70px; width: 200px; border: 1px solid black; color: black; background-color: #f1f1f1; text-align: center;"><div><b>Ime i prezime prodavača:</b><br> <?php echo $predmet['ime'] . ' ' . $predmet['prezime']; ?></div></div>				
	<div>
	<input style="margin-right: 1200px;" id="checkbox" type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $predmet['predmet_id']; ?>"/>
	</div>
	<div id="ime" style="margin-top: -145px;">	
		<div id="ime" name="ime" style="margin-bottom: 200px; background-color: #f1f1f1; height: 25px; width: 300px; text-align: center; border: 1px solid black; margin-left: -100px;"><?php echo $predmet['naziv']; ?></div>
		<div id="opis" style="margin-top: -180px; border: 1px solid; display: inline-block; border-color: black; background-color: #111; color: white; white-space: wrap; height: 230px; width: 300px; overflow-y: scroll; margin-left: -100px;"><?php echo $predmet['opis']; ?></div>
	</div>
	<div>
	<div><div id="pocetnacijena" style="margin-top: -130px; margin-left: 430px; height: 70px; width: 200px; border: 1px solid black; color: black; background-color: #f1f1f1; text-align: center;"><b>Početna cijena:</b><br><div style="font-size: 40px;"><?php echo $predmet['pocetna_cijena']; ?> kn<div></div></div>
	</div>

	<div style="margin-top: -180px;">
	<table id="najvecaponuda" width="20%" border="2" style="margin-right: -950px; text-align: center; height: 30px;">
		<tr>
			<th>Najveća ponuda</th>
			<th id="brojkupca">Broj kupaca</th>
		</tr>
<?php 
$ponudice=mysql_query("SELECT predmet_id,Count(DISTINCT korisnik_id) AS kupci,MAX(iznos_ponude) AS iznos FROM ponuda WHERE predmet_id='$idpredmet'"); 
while($ponudicice=mysql_fetch_array($ponudice)){
?>		
		<tr>
			<td style=" overflow-y: scroll; white-space: wrap;"><?php echo $ponudicice['iznos']; ?> kn</td>
			<td id="brojkupca"><?php echo $ponudicice['kupci']; ?></td>
		</tr>
	</table>
	<div>
<?php } ?>	
	<hr style="width: 700px; margin-top: 270px;">
<?php } ?>

</form>
</center>
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>