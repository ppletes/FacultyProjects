<?php  
header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>KORISNIČKA PODRŠKA</title>
	<link 
		href="style.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
	<link 
		href="styletvrtka.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>
</head>

<body>
<?php include('zaglavlje.php'); ?>
<br><br>
<form style="text-align: center; float: center; align: center;" method="post" action="" enctype="multipart/form-data">

<p style="font-family: Arial; font-size: 12px;">Molimo polja označena s <span style="color: rgb(210,36,36); font-weight: bold;">*</span> ne ostavljajte prazna.</p>

<br><br>

<div style="font-family: Arial;">
<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$sqlll=mysqli_query($conn, "SELECT * FROM korisnik WHERE tip_id='1' AND korisnik_id NOT IN (SELECT moderator_id FROM tvrtka)");
?>
<label>ID MODERATOR <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<select name="moderator_id" style="height: 30px; text-align: center;" type="text">
<?php
while($rowww=mysqli_fetch_array($sqlll)){
?>
	<option value="<?php echo $rowww['korisnik_id']; ?>"><?php echo $rowww['ime']." ".$rowww['prezime']; ?></option>
<?php
}
?>
</select>
</div>

<br><br>

<div style="font-family: Arial;">

<div style="float: left; margin-left: 20%;">
<label>Naziv <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="naziv" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>Opis</label><br>
<input name="opis" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
</div>

<div style="float: right; margin-right: 20%;">
<label>Broj zaposlenika <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="broj_zaposlenika" style="height: 30px; text-align: center; width: 300px;" type="number"><br><br>
<label>Preostali odgovori <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="preostaliOdgovori" value="0" style="height: 30px; text-align: center; width: 300px;" disabled="disabled" type="number"><br><br>
<label>Zahtjev za +odgovor <span style="color: rgb(210,36,36); font-weight: bold;">*</span></label><br>
<input name="zahtjev" value="0" style="height: 30px; text-align: center; width: 300px;" disabled="disabled" type="number"><br><br>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="">
<button type="submit" style="display: inline-block; width: 10%;" name="unesi" class="gumb">UNESI</button>
<button type="submit" style="display: inline-block; margin-left: 3%; width: 10%;" name="odustani" class="gumb">Odustani</button>
</div>

<?php
if(isset($_POST['unesi'])){
	$moderator_id=$_POST['moderator_id'];
	$naziv=$_POST['naziv'];
	$opis=$_POST['opis'];
	$broj_zaposlenika=$_POST['broj_zaposlenika'];
	$preostaliOdgovori=$_POST['preostaliOdgovori'];
	$zahtjev=$_POST['zahtjev'];
	
	$servername = "localhost";
	$username = "iwa_2018";
	$password = "foi2018";
	$dbname = "iwa_2018_zb_projekt";
	
	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	
	if ($moderator_id=="" or $naziv=="" or $broj_zaposlenika=="" or $preostaliOdgovori=="" or $zahtjev==""){
		echo "<script>alert('Niste unijeli sve potrebne podatke.'); window.location='nova_tvrtka.php'</script>";
	}else{
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO tvrtka (moderator_id, naziv, opis, broj_zaposlenika, preostaliOdgovori, zahtjev) VALUES ('$moderator_id','$naziv', '$opis', '$broj_zaposlenika', '$preostaliOdgovori', '$zahtjev')";
 
		$con->exec($sql);
		echo "<script>alert('Uspiješno ste unijeli novu tvrtku!'); window.location='azur_tvrtka.php'</script>";

	}
}

if(isset($_POST['odustani'])){
	echo "<script> window.location='azur_tvrtka.php'</script>";
}
?>

<br>
</form>
<br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>