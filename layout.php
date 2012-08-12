<html>
	<head>
		<title>Ten Tweets Per User</title>
		<script type="text/javascript" src="jquery.js"></script>
		<script language="javascript">
			function toggle(id) {
				var aid = id + 'a';
				var imgid = id + 'img';
				if (document.getElementById(imgid).getAttribute('src') == 'img/icon_star_empty.gif') {
					$.ajax({
						type: "POST",
						// url: "http://localhost/tentweets/favorite.php",
						url: "http://tentweets.comuf.com/favorite.php",
						data: { 'do': 'create', 'id': id }
					}).done(function( msg ) {
						document.getElementById(imgid).setAttribute('src', 'img/icon_star_full.gif');
					});
				} else if (document.getElementById(imgid).getAttribute('src') == 'img/icon_star_full.gif') {
					$.ajax({
						type: "POST",
						// url: "http://localhost/tentweets/favorite.php",
						url: "http://tentweets.comuf.com/favorite.php",
						data: { 'do': 'destroy', 'id': id }
					}).done(function( msg ) {
						document.getElementById(imgid).setAttribute('src', 'img/icon_star_empty.gif');
					});
				} else {
					alert('star not empty nor full error');
				}
			}
		</script>
	</head>
	<body>
		<?php
			require_once('squareout.php');
		?>
	</body>
</html>
