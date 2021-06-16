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
<?php include('zaglavlje.php'); 

$id=$_SESSION['tvrtka_id'];

$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

$sql=mysqli_query($conn, "SELECT * FROM tvrtka WHERE tvrtka_id='$id'");
while($row=mysqli_fetch_array($sql)){  

?>
<br><br>
<form style="text-align: center; float: center; align: center;" method="post" action="" enctype="multipart/form-data">

<div style="float: center; text-align: center; align: center;">
<label>ZAHTJEV</label><br>
<input name="zahtjev" disabled="disabled" value="<?php echo $row['zahtjev']; ?>" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
<label>PREOSTALI ODGOVORI</label><br>
<input name="preostaliOdgovori" value="<?php echo $row['preostaliOdgovori']; ?>" disabled="disabled" style="height: 30px; text-align: center; width: 300px;" type="text"><br><br>
</div>
<br><br><br>
<div style="float: center; text-align: center; align: center;">
<button type="submit" style="width: 30%;" name="postavi" class="gumb">POSTAVI ZAHTJEV NA 0</button>
</div>

<?php
if(isset($_POST['postavi'])){
			if($row['zahtjev']=="1"){
					$servername = "localhost";
					$username = "iwa_2018";
					$password = "foi2018";
					$dbname = "iwa_2018_zb_projekt";

					$con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	
					$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sql = "UPDATE tvrtka SET zahtjev=\"0\", preostaliOdgovori=preostaliOdgovori+10 WHERE tvrtka_id='$id'";
 
					$con->exec($sql);
					echo "<script>alert('Uspiješno ste odobrili zahtjev za +odgpvorima.'); window.location='azur_tvrtka.php'</script>";
				}else{
					echo "<script>alert('Tvrtka nije poslala zahtjev za +odgovorima.'); window.location='azur_tvrtka.php'</script>";					
				}
}
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
