<?php
error_reporting(E_ALL & ~E_NOTICE);
require("lib/twitteroauth.php");
require_once('session.php');

function getnewtwitteroauth() {
	$twitteroauth = new TwitterOAuth('pGJGw6IpxeLrxKTEyqacg', 'yAdzlHokQjCiw7Eup4aH1mxuwJkFzsP9QaoM7GOneGU');
	return $twitteroauth;
}


function getrequesttoken($twitteroauth) {
	// $requesttoken = $twitteroauth->getRequestToken('http://localhost/tentweets/comeback.php');
	$requesttoken = $twitteroauth->getRequestToken('http://tentweets.comuf.com/comeback.php');
	return $requesttoken;
}

function saveinsession($requesttoken) {
	$_SESSION['oauth_token'] = $requesttoken['oauth_token'];
	$_SESSION['oauth_token_secret'] = $requesttoken['oauth_token_secret'];
}

function redirectordie($twitteroauth, $requesttoken) {
	if($twitteroauth->http_code==200){
		$url = $twitteroauth->getAuthorizeURL($requesttoken['oauth_token']);
		header('Location: '. $url);
	} else {
		die('Something wrong happened.');
	}
}

$twitteroauth = getnewtwitteroauth();
$requesttoken = getrequesttoken($twitteroauth);
saveinsession($requesttoken);
redirectordie($twitteroauth, $requesttoken);
?>
