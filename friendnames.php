<?php
require_once('session.php');
require_once('db.php');

function getfriendids($twitteroauth) {
	$friendidsobj = $twitteroauth->get('friends/ids');
	$friendids = $friendidsobj->ids;
	return $friendids;
}

function getfriendnames($twitteroauth, $friendids) {
	$friendnamesarray = $twitteroauth->get('/users/lookup', array('user_id' => implode(',', $friendids)));
	foreach ($friendnamesarray as $friendnameobj) {
		$friendnames[] = $friendnameobj->screen_name;
	}
	return $friendnames;
}


function deletefriendnames($loggedname) {
	mysql_query("DELETE FROM friendnames WHERE loggedname = '{$loggedname}'");
}

function savefriendnames($friendnames, $loggedname) {
	foreach ($friendnames as $friendname) {
		saveindb($friendname, $loggedname);
	}
}

function saveindb($friendname, $loggedname) {
	$query = mysql_query("INSERT INTO friendnames (friendname, loggedname) VALUES ('{$friendname}', '{$loggedname}')");
}

function loadfriendnames($twitteroauth, $loggedname, $page) {
	$query = loadfromdb($loggedname, $page);
	while (list($id, $friendname, $loggedname) = mysql_fetch_array($query)) {
		$tweetsarray = $twitteroauth->get('/statuses/user_timeline', array('screen_name' => $friendname, 'count' => 10));
		$myarray[$friendname] = array();
		foreach ($tweetsarray as $tweetobj) {
			$tweet = linkify(utf8_decode($tweetobj->text));
			$favorited = (string)$tweetobj->favorited;
			$tweetid = $tweetobj->id_str;
			array_push($myarray[$friendname], array($tweet, $favorited, $tweetid));
		}
	}
	return $myarray;
}

function loadfromdb($loggedname, $page) {
	$limitstart = $page * 10 - 9;
	$limitstep = 10;
	$query = mysql_query("SELECT * FROM friendnames WHERE loggedname = '{$loggedname}' LIMIT {$limitstart}, {$limitstep}");
	return $query;
}

function linkify($text) {
	$text = preg_replace("
		#((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie",
		"'<a href=\"$1\" target=\"_blank\">$3</a>$4'",
		$text
	);
	return $text;
}

function view($myarray, $page) {
	require_once('layout.php');
}


$friendids = getfriendids($twitteroauth);
$friendnames = getfriendnames($twitteroauth, $friendids);
if ($nosession) {
	deletefriendnames($loggedname);
	savefriendnames($friendnames, $loggedname);
}
$page = $_SESSION['page'];
$myarray = loadfriendnames($twitteroauth, $loggedname, $page);
view($myarray, $page);
?>
