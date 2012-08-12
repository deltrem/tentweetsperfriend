<?php
if ($myarray === null) {
	echo 'the end';
	die();
}

while (key($myarray) !== null) {
	echo key($myarray);
?>:<br><?php
	require('squarein.php');
?><br><?php
	next($myarray);
}
$randomid = rand(1, 1000000);
// echo "<a href=\"http://localhost/tentweets/?randomid={$randomid}\">next</a>";
echo "<a href=\"http://tentweets.comuf.com/?randomid={$randomid}\">more</a>";
