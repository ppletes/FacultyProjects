<?php
mysql_connect('localhost','iwa_2017','foi2017');
mysql_select_db('iwa_2017_zb_projekt');

$datum=date("Y-m-d H:i:s");
$sql=mysql_query("SELECT aukcija.aukcija_id,aukcija.moderator_id,aukcija.naziv,aukcija.opis,aukcija.datum_vrijeme_pocetka,aukcija.datum_vrijeme_zavrsetka,
						korisnik.korisnik_id,korisnik.ime,korisnik.prezime
				FROM aukcija 
					INNER JOIN korisnik ON korisnik.korisnik_id=aukcija.moderator_id 
				WHERE datum_vrijeme_zavrsetka>'$datum'
				ORDER BY datum_vrijeme_zavrsetka DESC");

$sqll=mysql_query("SELECT aukcija.aukcija_id,aukcija.moderator_id,aukcija.naziv,aukcija.opis,aukcija.datum_vrijeme_pocetka,aukcija.datum_vrijeme_zavrsetka,
						korisnik.korisnik_id,korisnik.ime,korisnik.prezime
				FROM aukcija 
					INNER JOIN korisnik ON korisnik.korisnik_id=aukcija.moderator_id 
				WHERE datum_vrijeme_zavrsetka>'$datum' or datum_vrijeme_zavrsetka IS NULL
				ORDER BY datum_vrijeme_pocetka DESC");

$sqlll=mysql_query("SELECT aukcija.aukcija_id,aukcija.moderator_id,aukcija.naziv,aukcija.opis,aukcija.datum_vrijeme_pocetka,aukcija.datum_vrijeme_zavrsetka,
						korisnik.korisnik_id,korisnik.ime,korisnik.prezime
				FROM aukcija 
					INNER JOIN korisnik ON korisnik.korisnik_id=aukcija.moderator_id 
				ORDER BY datum_vrijeme_pocetka DESC");
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
?>
<form method="post" action="">
<div id="gumbici">
<input style="margin-left: 45px; width: 150px; text-align: center;" id="unesiauk" name="unesiauk" class="unesi" type="submit" Value="Nova aukcija">
<input style="margin-left: 40px; width: 150px;" id="urediaukciju" name="urediaukciju" class="unesi" type="submit" Value="Uredi aukciju">
<input style="margin-left: 40px; width: 150px;" id="obrisi" name="obrisi" type="submit" class="obrisi" value="Obriši">
</div>
<input style="margin-left: 40px; width: 150px;" id="otvori" name="otvori" type="submit" class="obrisi" value="Otvori">
<div id="gumbici">
<input style="margin-left: 40px; width: 150px;" type="submit" value="Zatvori aukciju" class="unesi" id="zatvoriaukciju" name="zatvoriaukciju">
</div>
<input type="submit" id="upit" style="width: 30px; height: 23px; margin-left: 90px;" value="?" target="_blank" onclick="window.open('pretrazi_opis.html')" />
<?php
if (isset($_POST['unesiauk'])){
header("Location: nova_aukcija.php");
}


if(isset($_POST['otvori'])){
	$checkbox = $_POST['checkbox'];
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: pretrazi.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
	$id=$_POST['checkbox'][$i];
	$_SESSION['aukcija_id']=$id;
	header("Location: predmeti.php");		
	}
}

if(isset($_POST['urediaukciju'])){
	$checkbox = $_POST['checkbox'];
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: pretrazi.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
		$id=$_POST['checkbox'][$i];
		$_SESSION['aukcija_id']=$id;
		header("Location: uredi_aukcija.php");
	}
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: pretrazi.php");
	}
}


if(isset($_POST['detalji'])){
	$checkbox = $_POST['checkbox'];
	for($i=1;$i>count($_POST['checkbox']);$i++){
	header("Location: pretrazi.php");
	}
	for($i=0;$i<count($_POST['checkbox']);$i++){
		$id=$_POST['checkbox'][$i];
		$_SESSION['aukcija_id']=$id;
		header("Location: detalji.php");
	}
}

if (isset($_POST['obrisi'])){
$checkbox = $_POST['checkbox'];
for($i=1;$i>count($checkbox);$i++){
header("Location: pretrazi.php"); }
for($i=0;$i<count($checkbox);$i++){
$del_id = $checkbox[$i]; 
mysql_query("DELETE FROM aukcija WHERE aukcija_id='$del_id'");
echo "<script>alert ('Aukcija je uspiješno obrisana');</script>";
}
header("Refresh:0; url=pretrazi.php");
}

if(isset($_POST['zatvoriaukciju'])){
$checkbox = $_POST['checkbox'];
for($i=1;$i>count($checkbox);$i++){
header("Location: pretrazi.php"); }
	for($i=0;$i<count($checkbox);$i++){
	$aid = $checkbox[$i]; 
	$date=date("Y-m-d H:i:s");
	mysql_query("UPDATE aukcija SET datum_vrijeme_zavrsetka='$date' WHERE aukcija_id='".$aid."'");
	echo "<script>alert ('Aukcija je uspiješno zatvorena');</script>";
	}
header("Refresh:0; url=pretrazi.php");
} 
?>
<hr>
<center>
<br>
<div style="overflow-y: scroll;">
<?php if(!isset($_SESSION['korisnikpodaci'])){ ?>
<table style="border: solid 1px; text-align: center; margin-bottom: -100px; background: #f1f1f1; height: 400px;" border="2" align="center" width="70%">
<tr height="30px">
	<th>Označi</th>
	<th>Aukcija</th>
	<th>Opis</th>
	<th>Datum i vrijeme završetka</th>
	<th>Stanje</th>
	<th>Broj predmeta</th>
</tr>
<?php while ($gtablica=mysql_fetch_array($sql)){ $idaukcija=$gtablica['aukcija_id'];?>
<tr>
	<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $gtablica['aukcija_id']; ?>"/></td>
	
	<td><?php echo $gtablica['naziv']; ?></td>
	
	<td><?php echo $gtablica['opis']; ?></td>
		
	<td id="datum"><?php 
					$datumic=$gtablica['datum_vrijeme_zavrsetka'];
					$formatdatumic = date("d.m.Y H:m:s", strtotime($datumic));
					if ($datumic==NULL){
						echo $datumic;
					}else{
					echo $formatdatumic; }?>			
				</td>
		
	<td><b>
	<?php
if ($gtablica['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){ 
		echo "Otvorena";
	}else{
		echo "Zatvorena";
	}
if (empty($gtablica['datum_vrijeme_zavrsetka'])){
	echo " ";
}
	?>
	</b></td>
	
	<?php $broj=mysql_query("SELECT aukcija_id,Count(predmet_id) AS predmeti,Count(DISTINCT korisnik_id) AS prodavaci FROM predmet WHERE aukcija_id='$idaukcija'"); while($maxbroj=mysql_fetch_array($broj)){ ?>
	
	<td><?php echo $maxbroj['predmeti']; } ?></td>
<?php } ?>
</tr>
</table>
	<?php }elseif ($_SESSION['tip_id']=='1') { ?>
<table style="border: solid 1px; text-align: center; margin-bottom: -100px; background: #f1f1f1; height: 400px;" border="2" align="center" width="70%">
<tr>
	<th>Označi</th>
	<th>Aukcija</th>
	<th>Opis</th>
	<th id="datum_pocetak">Datum i vrijeme početka</th>
	<th>Datum i vrijeme završetka</th>
	<th>Stanje</th>
	<th id="moderator_aukcije">Moderator</th>
	<th id="broj_prodavaca">Broj prodavača</th>
	<th>Broj predmeta</th>
</tr>
<?php while ($gtablica=mysql_fetch_array($sqll)){ $idaukcijaa=$gtablica['aukcija_id'];?>
<tr>
	<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo	$gtablica['aukcija_id']; ?>"/></td>
	
	<td><?php echo $gtablica['naziv']; ?></td>
	
	<td><?php echo $gtablica['opis']; ?></td>
	
	<td id="datum_pocetak"><?php 
		$datumic=$gtablica['datum_vrijeme_pocetka'];
		$formatdatumic = date("d.m.Y H:m:s", strtotime($datumic));
		echo $formatdatumic;
	?></td>
	
	<td id="datum"><?php 
					$dattumic=$gtablica['datum_vrijeme_zavrsetka'];
					$formatdatumic = date("d.m.Y H:m:s", strtotime($dattumic));
					if ($dattumic==NULL){
						echo $dattumic;
					}else{
					echo $formatdatumic; }?>			
				</td>
	
		
	<td><b>
	<?php
if ($gtablica['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){ 
		echo "Otvorena";
	}else{
		echo "Zatvorena";
	}
if (empty($gtablica['datum_vrijeme_zavrsetka'])){
	echo " ";
}
	?>
	</b></td>
	
	<td id="moderator_aukcije">	<?php echo $gtablica['ime'].' '.$gtablica['prezime']; ?></td>

	<?php $broj=mysql_query("SELECT aukcija_id,Count(predmet_id) AS predmeti,Count(DISTINCT korisnik_id) AS prodavaci FROM predmet WHERE aukcija_id='$idaukcijaa'"); while($maxbroj=mysql_fetch_array($broj)){ ?>
	<td id="broj_prodavaca"><?php echo $maxbroj['prodavaci']; ?></td>
	
	<td><?php echo $maxbroj['predmeti']; }?></td>
<?php } ?>
</tr>
</table>
<?php }elseif ($_SESSION['tip_id']=='0') { ?>

<p id="ad"><i>Odaberite datum početka i završetka kako bi se suzio izbor aukcija</i></p>

<label><b><i>Od</i></b></label>   <input id="datumicod" class="filtriraj" name="datumicod" placeholder="dd.mm.yyyy hh:mm:ss" type="text" size="40%" style="text-align: center; height: 30px; width: 250px;" />
<label><b><i>Do</i></b></label>   <input id="datumicdo" class="filtriraj" name="datumicdo" placeholder="dd.mm.yyyy hh:mm:ss" type="text" size="40%" style="text-align: center; height: 30px; width: 250px;" />   
<input type="submit" name="prikazi" id="prikazi" class="gumb" value="Prikaži" />
<br id="ad"><br id="ad">

<table class="tablicica" style="border: solid 1px; text-align: center; margin-bottom: -100px; background: #f1f1f1; height: 400px;" border="2" id="tra" align="center" width="70%">
<tr>
	<th>Označi</th>
	<th>Aukcija</th>
	<th>Opis</th>
	<th id="datum_pocetak">Datum i vrijeme početka</th>
	<th>Datum i vrijeme završetka</th>
	<th>Stanje</th>
	<th id="moderator_aukcije">Moderator</th>
	<th id="broj_prodavaca">Broj prodavača</th>
	<th>Broj predmeta</th>
</tr>
<?php 

if (isset($_POST['prikazi'])){

$datumicod= $_POST['datumicod'];
$daform= date("Y-m-d H:i:s", strtotime($_POST['datumicod']));
$datumicdo= $_POST['datumicdo'];
$daformm= date("Y-m-d H:i:s", strtotime($_POST['datumicdo']));


$filter=mysql_query("SELECT *,
						korisnik.korisnik_id,korisnik.ime,korisnik.prezime
				FROM aukcija 
					INNER JOIN korisnik ON korisnik.korisnik_id=aukcija.moderator_id 
				WHERE datum_vrijeme_pocetka BETWEEN '$daform' AND '$daformm' AND datum_vrijeme_zavrsetka BETWEEN '$daform' and '$daformm' ORDER BY datum_vrijeme_pocetka DESC");

	if(empty($datumicod) && empty($datumicdo)){
		echo "<script>alert('Niste unjeli datum'); window.location='pretrazi.php'</script>";
	}elseif(preg_match("/^[a-z]$/i", $datumicod) or preg_match("/^(0|[1-9][0-9]*)$/i", $datumicod) or preg_match("/^[^\w.]$/i", $datumicod) or preg_match("/^[a-z]$/i", $datumicdo) or preg_match("/^(0|[1-9][0-9]*)$/i", $datumicdo) or preg_match("/^[^\w.]$/i", $datumicdo)){
		echo "<script>alert('Niste unjeli ispravan format datuma'); window.location='pretrazi.php'</script>";	
	}else{

		while ($filterr=mysql_fetch_array($filter)){ $idaukcijo=$filterr['aukcija_id'];?>
			
			<tr>
				<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo	$idaukcijo; ?>"/></td>
				<td><?php echo $filterr['naziv']; ?></td>
				<td><?php echo $filterr['opis']; ?></td>
				<td id="datum_pocetak"><?php 
					$daatumicc=$filterr['datum_vrijeme_pocetka'];
					$formatdatumicc = date("d.m.Y H:m:s", strtotime($daatumicc));
					echo $formatdatumicc; ?>
				</td>
				<td id="datum"><?php 
					$daaatumicc=$filterr['datum_vrijeme_zavrsetka'];
					$formatdatumicc = date("d.m.Y H:m:s", strtotime($daaatumicc));
					if ($daaatumicc==NULL){
						echo $daaatumicc;
					}else{
					echo $formatdatumicc; }?>			
				</td>
				<td><b>
					<?php if ($filterr['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){ 
						echo "Otvorena";
					}else{
						echo "Zatvorena";
					}
					if (empty($filterr['datum_vrijeme_zavrsetka'])){
						echo " ";
					} ?>
				</b></td>
				<td id="moderator_aukcije">	<?php echo $filterr['ime'].' '.$filterr['prezime']; ?></td>

				<?php $brojj=mysql_query("SELECT aukcija_id,Count(predmet_id) AS predmeti,Count(DISTINCT korisnik_id) AS prodavaci FROM predmet WHERE aukcija_id='$idaukcijo'"); 
				while($maxbrojj=mysql_fetch_array($brojj)){ ?>
				<td id="broj_prodavaca"><?php echo $maxbrojj['prodavaci']; ?></td>

				<td><?php echo $maxbrojj['predmeti']; }?></td>
			</tr>
		<?php } } ?>

<?php }else{ 
	while ($gtablicaaa=mysql_fetch_array($sqlll)){ $idaukcijaaa=$gtablicaaa['aukcija_id'];?>
			<tr>
				<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo	$idaukcijaaa; ?>"/></td>	
				<td><?php echo $gtablicaaa['naziv']; ?></td>	
				<td><?php echo $gtablicaaa['opis']; ?></td>
				<td id="datum_pocetak"><?php 
					$daatumic=$gtablicaaa['datum_vrijeme_pocetka'];
					$formatdatumic = date("d.m.Y H:m:s", strtotime($daatumic));
					echo $formatdatumic; ?>
				</td>	
				<td id="datum"><?php 
					$daaatumicc=$gtablicaaa['datum_vrijeme_zavrsetka'];
					$formatdatumicc = date("d.m.Y H:m:s", strtotime($daaatumicc));
					if ($daaatumicc==NULL){
						echo $daaatumicc;
					}else{
					echo $formatdatumicc; }?>			
				</td>
				<td><b>
					<?php if ($gtablicaaa['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){ 
						echo "Otvorena";
					}else{
						echo "Zatvorena";
					}
					if (empty($gtablicaaa['datum_vrijeme_zavrsetka'])){
						echo " ";
					} ?>
				</b></td>
				<td id="moderator_aukcije">	<?php echo $gtablicaaa['ime'].' '.$gtablicaaa['prezime']; ?></td>
				<?php $brojj=mysql_query("SELECT aukcija_id,Count(predmet_id) AS predmeti,Count(DISTINCT korisnik_id) AS prodavaci FROM predmet WHERE aukcija_id='$idaukcijaaa'"); 
				while($maxbrojj=mysql_fetch_array($brojj)){ ?>
				<td id="broj_prodavaca"><?php echo $maxbrojj['prodavaci']; ?></td>
				<td><?php echo $maxbrojj['predmeti']; }?></td>
			</tr>
	<?php } ?>
<?php } ?>
</table> 
	<?php }elseif ($_SESSION['tip_id']=='2') { ?>
<table style="border: solid 1px; text-align: center; margin-bottom: -100px; background: #f1f1f1; height: 400px;" border="2" align="center" width="70%">
<tr height="30px">
	<th>Označi</th>
	<th>Aukcija</th>
	<th>Opis</th>
	<th>Datum i vrijeme završetka</th>
	<th>Stanje</th>
	<th>Broj predmeta</th>
</tr>
<?php while ($gtablica=mysql_fetch_array($sql)){ $idaukcija=$gtablica['aukcija_id'];?>
<tr>
	<td><input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $gtablica['aukcija_id']; ?>"/></td>
	
	<td><?php echo $gtablica['naziv']; ?></td>
	
	<td><?php echo $gtablica['opis']; ?></td>
		
	<td id="datum"><?php 
					$daaatumic=$gtablica['datum_vrijeme_zavrsetka'];
					$formatdatumic = date("d.m.Y H:m:s", strtotime($daaatumic));
					if ($daaatumic==NULL){
						echo $daaatumic;
					}else{
					echo $formatdatumic; }?>			
				</td>	
	<td><b>
	<?php
if ($gtablica['datum_vrijeme_zavrsetka']>date("Y-m-d H:i:s")){ 
		echo "Otvorena";
	}else{
		echo "Zatvorena";
	}
if (empty($gtablica['datum_vrijeme_zavrsetka'])){
	echo " ";
}
	?>
	</b></td>
	
	<?php $broj=mysql_query("SELECT aukcija_id,Count(predmet_id) AS predmeti,Count(DISTINCT korisnik_id) AS prodavaci FROM predmet WHERE aukcija_id='$idaukcija'"); while($maxbroj=mysql_fetch_array($broj)){ ?>
	
	<td><?php echo $maxbroj['predmeti']; } ?></td>
<?php } ?>
</tr>
</table>
<?php } ?>	
	
</div>
</center>
</form>
<br>

</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>