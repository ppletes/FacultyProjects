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

$id=$_SESSION['predmet_id'];
?>
<br>
<form method="post" action="" style="font-family: Times New Roman, Times, serif; size: large;">
<div style="text-align: center;">
<label>Unesi svoju ponudu (HRK):</label><br><br>
<input type="number_format" id="iznos_ponude" name="iznos_ponude" style="height: 40px; width: 200px;">

<button type="submit" id="unesiponudu" class="unesi" name="unesiponudu">Unesi</button>
</div>


<?php
if (isset($_POST['unesiponudu'])){

$poo=mysql_query("SELECT predmet_id, MAX(iznos_ponude) AS iznos FROM ponuda WHERE predmet_id='$id'");
$poon = mysql_fetch_array($poo);

	$iznos_ponude=$_POST['iznos_ponude'];
	$datum_vrijeme_ponude=date("Y-m-d H:i:s");
	$korisnik_id=$_SESSION['korisnik_id'];
	$predmet_id=$_SESSION['predmet_id'];

	if($iznos_ponude==""){
	 echo "<script>alert('Niste unjeli svoju cijenu za predmet');window.location='ponuda.php';</script>";
	}elseif($iznos_ponude<$poon['iznos']){
	 echo "<script>alert('Vaša ponuda mora biti veća od trenutno najveće');window.location='ponuda.php';</script>";
	}elseif($iznos_ponude>$poon['iznos']){
$servername = "localhost";
$username = "iwa_2017";
$password = "foi2017";
$dbname = "iwa_2017_zb_projekt";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $ponuda = "INSERT INTO ponuda (predmet_id, korisnik_id, datum_vrijeme_ponude, iznos_ponude)
    VALUES ('$predmet_id', '$korisnik_id', '$datum_vrijeme_ponude', '$iznos_ponude')";
    $conn->exec($ponuda);
    echo "<script>alert('Uspiješno ste unjeli ponudu'); window.location= 'predmeti.php';</script>";
    }
catch(PDOException $e)
    {
    echo $ponuda . "<br>" . $e->getMessage();
    }

$conn = null;
} } 

?>
</form>
<br>
<form>
<center>
<label style="font-family: Times New Roman, Times, serif; size: large;">Največa ponuda:</label>
<?php 
$max=mysql_query("SELECT ponuda.predmet_id,ponuda.korisnik_id,korisnik.korisnik_id,korisnik.ime,korisnik.prezime,ponuda.iznos_ponude FROM ponuda INNER JOIN korisnik ON ponuda.korisnik_id=korisnik.korisnik_id WHERE ponuda.predmet_id='$id' GROUP BY ponuda.iznos_ponude DESC LIMIT 1");
 while($maxx=mysql_fetch_array($max)){ 
 ?>
<input type="text" readonly="" style="background: #f1f1f1; text-align: center; height: 40px; font-size: 15px;" value="<?php echo $maxx['ime'].' '.$maxx['prezime']; ?>">
<input type="text" readonly="" style="background: #f1f1f1; text-align: center; height: 40px; font-size: 15px;" value="<?php echo $maxx['iznos_ponude']; ?> kn">
<?php } ?>
</center>
<table style="background: #f1f1f1;" border="1" cellspacing="1" cellpadding="10" class="tablice" align="center">
  <tr>
    <th>Ime i prezime</th>
	<th>Datum i vrijeme ponude</th>
    <th>Iznos ponude (HRK)</th> 
  </tr><br>

<?php
$sql="SELECT ponuda.korisnik_id,ponuda.predmet_id,ponuda.datum_vrijeme_ponude,ponuda.iznos_ponude,korisnik.korisnik_id,korisnik.ime,korisnik.prezime FROM ponuda INNER JOIN korisnik ON korisnik.korisnik_id=ponuda.korisnik_id WHERE ponuda.predmet_id='$id'";
$podaci=mysql_query($sql);

while($ponuda=mysql_fetch_assoc($podaci)){
echo "<tr>"; 
	echo "<td>".$ponuda['ime'].' '.$ponuda['prezime']."</td>";
	$po=$ponuda['datum_vrijeme_ponude']; $ponudaa=date("d.m.Y H:m:s", strtotime($po)); echo "<td>".$ponudaa."</td>";
	echo "<td>".$ponuda['iznos_ponude']."</td>";
echo "</tr>";
}
?>	  
</table>
</form>
<br><br>
</body>

<footer>
<?php
include ('podnozje.php');
?>
</footer>
</html>