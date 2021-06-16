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

<img src="http://www.pngmart.com/files/3/Auction-PNG-Clipart.png" align="middle" height="680" width="1200" class="slikaPocetna" />

<pre class="bok2">
Dobrodošli na 
</pre>
<pre class="bok1">
AUKCIJE_hr
</pre>

</body>

<footer>
	<hr>
	<div class="vrijeme">
	<script type="text/javascript">
	document.write ('<p><span id="date-time">', new Date().toLocaleString(), '<\span>.<\p>')
	if (document.getElementById) onload = function () {
	setInterval ("document.getElementById ('date-time').firstChild.data = new Date().toLocaleString()", 50)
	}
	</script>
	</div>
	<p class="c">
		© Sva prava pridržana
	</p>
</footer>
</html>