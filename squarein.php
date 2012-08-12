<?php
$dbitem = current($myarray);

while(key($dbitem) !== null) {
	$current = current($dbitem);
	
	$tweet = $current[0];
	$favorited = (string) $current[1];
	$tweetid = $current[2];
	
	if ($favorited) {echo "<img src=\"img/icon_star_full.gif\" onclick=\"toggle('{$tweetid}')\" id=\"{$tweetid}img\">"; } 
	else {echo "<img src=\"img/icon_star_empty.gif\" onclick=\"toggle('{$tweetid}')\" id=\"{$tweetid}img\">"; }
	echo $tweet;
	echo '<br>';
	next($dbitem);
}
?>
