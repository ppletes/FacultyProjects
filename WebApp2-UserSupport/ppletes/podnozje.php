<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8"/>
	<title>KORISNIČKA PODRŠKA</title>
	<link 
		href="style.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>	
	<link 
		href="stylezagpod.css" 
		rel="stylesheet" 
		type="text/css"
		media="screen"
	/>
</head>

<footer>
	<hr>
	<div class="footer-time">
	<script type="text/javascript">
	document.write ('<p><span id="datum_vrijeme">', new Date().toLocaleString(), '<\span>.<\p>')
	if (document.getElementById) onload = function(){
		setInterval ("document.getElementById ('datum_vrijeme').firstChild.data = new Date().toLocaleString()", 50)
	}
	</script>
	</div>
	<p class="footer-prava">
		© Sva prava pridržana - 2019
	</p>
</footer>
</html>