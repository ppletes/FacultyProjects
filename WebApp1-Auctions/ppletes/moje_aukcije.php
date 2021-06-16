<?php
mysql_connect('localhost','iwa_2017','foi2017');
mysql_select_db('iwa_2017_zb_projekt'); 
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

$sql=mysql_query("SELECT aukcija.datum_vrijeme_zavrsetka,aukcija.aukcija_id,predmet.aukcija_id,predmet.predmet_id,ponuda.predmet_id,predmet.naziv,iznos_ponude,ponuda.korisnik_id FROM ponuda INNER JOIN predmet ON predmet.predmet_id=ponuda.predmet_id INNER JOIN aukcija ON aukcija.aukcija_id=predmet.aukcija_id WHERE ponuda.korisnik_id='$id'");
?>

<div style="text-align: center;">
<p style="font-family: Arial; font-size: 150%;">Stanje ponuda na otvorenoj aukciji koje sam predao/la</p>

<p style="margin-left: 650px; font-family: Arial; font-size: 60%;"><i><u>Broj ponude se kreće od 0-... Najveća ponuda je nulta ponuda</u></i></p>
<br><br>
<?php 

while($rezultat=mysql_fetch_assoc($sql)) { $ponudica=$rezultat['iznos_ponude']; $idpredmet=$rezultat['predmet_id']; $idaukc=$rezultat['aukcija_id'];
	if ($rezultat['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){	?>

	<label>AUKCIJA</label>
	<input type="text" style="font-weight: bold; width: 200px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php 
	$aukcijaa=mysql_query("SELECT aukcija_id,naziv FROM aukcija WHERE aukcija_id='$idaukc'");
	while($aukcijea=mysql_fetch_array($aukcijaa)){ echo $aukcijea['naziv']; } ?>">
	
	<label>Naziv predmeta</label>
	<input type="text" style="font-weight: bold; width: 250px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php echo $rezultat['naziv']; ?>">
					
	<label>Iznos ponude</label>
	<input type="number_format" style="width: 150px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php echo $rezultat['iznos_ponude']; ?> kn">
<br>
	<label>Vaša ponuda je trenutno na mjestu broj:</label>
	<input type="number_format" style="width: 40px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php
	$mjesto=mysql_query("SELECT predmet_id,iznos_ponude,korisnik_id,COUNT(*) AS mjesti FROM ponuda WHERE iznos_ponude>'$ponudica' AND predmet_id='$idpredmet' ORDER BY iznos_ponude DESC "); 
		while($brojmjesta=mysql_fetch_assoc($mjesto)) {
			echo $brojmjesta['mjesti']; }?>"><hr style="width: 500px;"><br>
<?php } } ?>	
</div>

<br><br>

<div style="text-align: center;">
<p style="font-family: Arial; font-size: 150%;">Zatvorene aukcije na kojima sam prodavao/la</p>

<?php 
$ponuda=mysql_query("SELECT aukcija.datum_vrijeme_zavrsetka,aukcija.aukcija_id,
							predmet.aukcija_id,predmet.predmet_id,predmet.korisnik_id,predmet.naziv
					FROM predmet
						INNER JOIN aukcija ON aukcija.aukcija_id=predmet.aukcija_id 
					WHERE predmet.korisnik_id='$id'");

	while ($rezultati=mysql_fetch_array($ponuda)){  $idpred=$rezultati['predmet_id']; $idauk=$rezultati['aukcija_id'];
		if ($rezultati['datum_vrijeme_zavrsetka']<date("Y-m-d H:i:s")){ ?>

<label>AUKCIJA</label>
<input type="text" style="font-weight: bold; width: 200px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php 
$aukcija=mysql_query("SELECT aukcija_id,naziv FROM aukcija WHERE aukcija_id='$idauk'");
while($aukcije=mysql_fetch_array($aukcija)){ echo $aukcije['naziv']; } ?>">

		
<label>Naziv predmeta</label>
<input type="text" style="font-weight: bold; width: 250px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php echo $rezultati['naziv']; ?>">


<label>Dobitnik</label>
<input type="text" style="width: 150px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php 
$max=mysql_query("SELECT ponuda.korisnik_id,iznos_ponude,ponuda.predmet_id,
							korisnik.korisnik_id,korisnik.ime,korisnik.prezime
						FROM ponuda
							INNER JOIN korisnik ON korisnik.korisnik_id=ponuda.korisnik_id
						WHERE ponuda.predmet_id='$idpred' GROUP BY iznos_ponude DESC LIMIT 1"); 
$maxi=mysql_query("SELECT datum_vrijeme_zavrsetka FROM aukcija");
	while($maxx=mysql_fetch_array($max) and $maxii=mysql_fetch_array($maxi)) {
	if($maxii['datum_vrijeme_zavrsetka']<date("Y-m-d H:i:s")){
	echo $maxx['ime'].' '.$maxx['prezime']; }else{ echo " "; } } ?>"> 
	
	<br>
	
<label>Konačan iznos aukcije</label>
<input type="text" style="width: 150px; text-align: center; height: 30px; font-size: 80%;" readonly="" value="<?php 
$max=mysql_query("SELECT ponuda.korisnik_id,iznos_ponude,ponuda.predmet_id,
							korisnik.korisnik_id,korisnik.ime,korisnik.prezime
						FROM ponuda
							INNER JOIN korisnik ON korisnik.korisnik_id=ponuda.korisnik_id
						WHERE ponuda.predmet_id='$idpred' GROUP BY iznos_ponude DESC LIMIT 1"); 
	while($maxx=mysql_fetch_array($max)) { echo $maxx['iznos_ponude']; } ?> kn"><hr style="width: 500px;"><br>

<?php } }?>
</div>
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html> 