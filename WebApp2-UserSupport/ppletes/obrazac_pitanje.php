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
<br>

<?php 
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$id=$_SESSION['tvrtka_id'];
$naziv = mysqli_query($conn,"SELECT * FROM tvrtka WHERE tvrtka_id = '$id'");
$sql = mysqli_query($conn,"SELECT DISTINCT pitanje.pitanje_id, pitanje.datum_vrijeme_pitanja, pitanje.naslov, pitanje.tvrtka_id, odgovor.pitanje_id FROM pitanje
									LEFT JOIN odgovor ON pitanje.pitanje_id=odgovor.pitanje_id 
									WHERE pitanje.tvrtka_id='$id' ORDER BY datum_vrijeme_pitanja DESC");
if (!$sql) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>
<form method="post" action="" enctype="multipart/form-data">
<?php
if(isset($_POST['odustani'])){ 
	header ("Location: tvrtka.php");
} 
?>
<div style="float: center; text-align: center; align: center; display: block;">
<?php
	if(isset($_POST['podaci'])){
		$checkbox = $_POST['checkbox'];
			for($i=1;$i>count($_POST['checkbox']);$i++){
				header("Location: obrazac_pitanje.php");
			}
			for($i=0;$i<count($_POST['checkbox']);$i++){
				$id=$_POST['checkbox'][$i];
				$_SESSION['pitanje_id']=$id;
				header("Location: podaci.php");
			}
	}


echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
<tr>
<th id=\"obrazac_oznaci\">Označi</th>
<th style=\"height: 50px;\">NASLOV PITANJA</th>
<th>DATUM I VRIJEME PITANJA</th>
<th>STATUS</th>
</tr>";
	while($row = mysqli_fetch_array($sql)){ $id=$row['pitanje_id']; 
		echo "<tr>";
		echo "<td id=\"obrazac_oznaci\">" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['pitanje_id']; ?>"/> <?php "</td>";
		echo "<td style=\"height: 30px;\">" . $row['naslov'] . "</td>";
		$da=$row['datum_vrijeme_pitanja']; $datt=date("d.m.Y H:m:s", strtotime($da)); echo "<td>".$datt."</td>";
		if($id != NULL){
			echo "<td>Ima odgovor</td>";
		}else{
			echo "<td>Nema odgovor</td>";
		}
		
		echo "</tr>";
	}
echo "</table>";
?>
<input id="obrazac_oznaci" style="float: left; width: 11%;" type="submit" class="gumb" name="podaci" value="PODACI" onclick="window.location.replace('podaci.php')"/>
<br><br><br><p id="obrazac_oznaci" style="float: left; margin-top: -1%; font-family: Arial; font-size: 12px;"><b>Odabirom pitanja možete <br> vidjeti ostale podatke</b></p>
<br>
<br>
<p style="text-align: center; align: center; float: center; font-family: Arial; font-size: 15px;"><b>Ovdje možete postaviti pitanje odabranoj tvrtci.</b><br> Sve što je potrebno jest popuniti niže navedena polja ( <span style="color: rgb(210,36,36);">*</span> označava obavezna polja).<br> Pokušat ćemo Vam osigurati odgovor u što kraćem vremenu!</p>
<br>
<?php while($n = mysqli_fetch_array($naziv)){?>
<div style="font-family: Arial; text-align: center; float: center; align: center;">
	<label style="font-weight: bold;">ZA</label>
	<input name="naziv" style="text-align: center; align: center; float: center; font-weight: bold; color: rgb(210,36,36);" type="text" value="<?php echo $n['naziv']; ?>">
</div>
<br><br>
<div style="float: left; margin-left: 20%; font-family: Arial;">
	<label style="font-size: 15px;">O ČEMU SE RADI? <span style="color: rgb(210,36,36);">*</span></label><br>
	<input name="naslov" type="text" placeholder="Naslov pitanja" style="font-size: 15px; text-align: center; height: 30px;" size="40%">
	<br><br>
	<label style="font-size: 15px;">PODIJELITE FOTOGRAFIJU: <span style="color: rgb(210,36,36);">*</span></label><br>
	<input name="slika" type="text" placeholder="URL fotografije" style="font-size: 15px; text-align: center; height: 30px;" size="40%">
	<br><br>
	<label style="font-size: 15px;">PODIJELITE VIDEO:</label><br>
	<input name="video" type="text" placeholder="URL videa" style="font-size: 15px; text-align: center; height: 30px;" size="40%">
</div>
<div style="float: right; margin-right: 20%; font-family: Arial;">
	<label style="font-size: 15px;">ŠTO VAS INTERESIRA? <span style="color: rgb(210,36,36);">*</span></label><br>
	<textarea name="pitanje" type="text" placeholder="Pitanje" style="resize: none;height: 100px; font-size: 15px; text-align: center;"></textarea>
</div>
<br>
<?php } ?>

<div style="float: right; margin-right: 23%; margin-top: 2%;">
<button type="submit" style="display: inline-block;" name="postavi" class="gumb">POSTAVI</button>
<button type="submit" name="odustani" class="gumb">Odustani</button>
</div>

<br><br><br><br><br><br>
<?php
if (isset($_POST['postavi'])){

	$tvrtka_id=$_SESSION['tvrtka_id'];
	$naslov=$_POST['naslov'];
	$pitanje=$_POST['pitanje'];
	$datum_vrijeme_pitanja=date("Y-m-d H:i:s");
	$slika=$_POST['slika'];
	$video=$_POST['video'];

	if($pitanje==""){
		echo "<script>alert('Niste unjeli sve podatke. Nesmijete ostaviti prazno * označena polja');window.location='obrazac_pitanje.php';</script>";
	}elseif($naslov==""){
		echo "<script>alert('Niste unjeli sve podatke. Nesmijete ostaviti prazno * označena polja');window.location='obrazac_pitanje.php';</script>";
	}elseif($slika==""){
		echo "<script>alert('Niste unjeli sve podatke. Nesmijete ostaviti prazno * označena polja');window.location='obrazac_pitanje.php';</script>";		
	}else{
		$servername = "localhost";
		$username = "iwa_2018";
		$password = "foi2018";
		$dbname = "iwa_2018_zb_projekt";


try {
	$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	
    $pitanje_baza = "INSERT INTO pitanje (tvrtka_id, naslov, datum_vrijeme_pitanja, tekst, slika, video)
    VALUES ('$tvrtka_id', '$naslov', '$datum_vrijeme_pitanja', '$pitanje', '$slika', '$video')";
    $con->exec($pitanje_baza);
    echo "<script>alert('Uspiješno ste postavili novo pitanje. Vidljivo je u niže prikazanoj tablici.'); window.location= 'obrazac_pitanje.php';</script>";
    }
catch(PDOException $e)
    {
    echo $pitanje_baza . "<br>" . $e->getMessage();
    }

$con = null;
} 
} 

?>

</div>
</form>
<?php mysqli_close($conn); ?>

<br><br><br><br><br><br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>