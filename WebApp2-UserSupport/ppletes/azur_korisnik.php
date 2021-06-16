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
<form method="post" action="" enctype="multipart/form-data">
<?php 
if(isset($_POST['unesi'])){
	echo "<script>window.location= 'novi_korisnik.php';</script>";
}

if(isset($_POST['uredi'])){
			$checkbox = $_POST['checkbox'];
			for($i=1;$i>count($_POST['checkbox']);$i++){
				header("Location: azur_korisnik.php");
			}
			for($i=0;$i<count($_POST['checkbox']);$i++){
				$id=$_POST['checkbox'][$i];
				$_SESSION['korisnik_id']=$id;
				header("Location: uredi_korisnik.php");
			}
}
?>

<?php
$conn=mysqli_connect("localhost","iwa_2018","foi2018","iwa_2018_zb_projekt");
mysqli_set_charset($conn,"utf8");

if (!isset($_GET['broj']) or !is_numeric($_GET['broj'])) {
  $broj = 0;
} else {
  $broj = (int)$_GET['broj'];
}

$sql=mysqli_query($conn, "SELECT * FROM korisnik LIMIT $broj, 5");


$ukupno=mysqli_num_rows($sql);

	if($ukupno>0){

	echo "<table style=\"background: #f1f1f1; font-family: Arial; text-align: center; width: 100%;\" align=center border=2>
		<tr>
			<th style=\"color: rgb(210,36,36);\">Označi</th>
			<th style=\"height: 50px;\">ID TIP</th>
			<th>KORISNIČKO IME</th>
			<th>LOZINKA</th>
			<th>IME</th>
			<th>PREZIME</th>
			<th>EMAIL</th>
			<th>SLIKA</th>
		</tr>";
		
	for($i=0; $i<$ukupno; $i++){
		$row=mysqli_fetch_array($sql);

		echo "<tr>";
			echo "<td>" ?> <input type="checkbox" name="checkbox[]" class="checkbox" value="<?php echo $row['korisnik_id']; ?>"/> <?php "</td>";
			echo "<td>" . $row['tip_id'] . "</td>";
			echo "<td>" . $row['korisnicko_ime'] . "</td>";
			echo "<td>" . $row['lozinka'] . "</td>";
			echo "<td>" . $row['ime'] . "</td>";
			echo "<td>" . $row['prezime'] . "</td>";
			echo "<td>" . $row['email'] . "</td>";
			echo "<td><img src=".$row['slika']." width=\"50\"height=\"50\" onclick=\"window.open(this.src, '_blank', 'left=20,top=20,width=200,height=200,toolbar=1,resizable=0');\"></td>";        
	}
	echo "</table>";
	}
?>
<div class="slipre" style="float: center; text-align: center; align: center; color: rgb(210,36,36);">
<?php
if($ukupno=='5'){
	echo '<a class="slipre" name="slijedece" style="float: center;" href="'.$_SERVER['PHP_SELF'].'?broj='.($broj+5).'">Slijedeće</a>';
}elseif($ukupno<'5'){
	echo '<a class="slipre" name="slijedece" style="display: none;" href="'.$_SERVER['PHP_SELF'].'?broj='.($broj+5).'">Slijedeće</a>';
}
$prethodno = $broj-5;
if($prethodno >= 0){
    echo '<a class="slipre" style="float: center;" href="'.$_SERVER['PHP_SELF'].'?broj='.$prethodno.'">Predhodno</a>';
}
?>
</div>
<br><br>
<div style="float: center; text-align: center; align: center;">
<button type="submit" style="width: 30%; display: inline-block; margin-right: 2%;" name="unesi" class="gumb">UNESI NOVOG KORISNIKA</button>
<button type="submit" style="width: 30%;" name="uredi" class="gumb">UREDI POSTOJEĆEG KORISNIKA</button>
</div>
</form>
<br>
</body>
<footer>
<?php include ('podnozje.php'); ?>
</footer>
</html>