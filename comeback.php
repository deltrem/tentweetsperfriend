<?php
error_reporting(E_ALL & ~E_NOTICE);
require("lib/twitteroauth.php");
require_once('session.php');
require_once('validate.php');

function isvalid() {
	if (isalphanum($_GET['oauth_verifier']) && isalphanum($_SESSION['oauth_token']) && isalphanum($_SESSION['oauth_token_secret'])) {
		return true;
	} else {
		return false;
	}
}

function iscorrect() {
	if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
		return true;
	} else {
		return false;
	}
}

function getnewtwitteroauth() {
	$twitteroauth = new TwitterOAuth('pGJGw6IpxeLrxKTEyqacg', 'yAdzlHokQjCiw7Eup4aH1mxuwJkFzsP9QaoM7GOneGU', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);  
	return $twitteroauth;
}

function getaccesstoken($twitteroauth) {
	$accesstoken = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
	return $accesstoken;
}

function saveaccesstoken($accesstoken) {
	$_SESSION['access_token'] = $accesstoken;
}

function getloggedname($accesstoken) {
	$loggedname = $accesstoken['screen_name'];
	return $loggedname;
}

function saveloggedname($loggedname) {
	$_SESSION['loggedname'] = $loggedname;
}


function gettweets() {
	$twitteroauth = getnewtwitteroauth();
	$accesstoken = getaccesstoken($twitteroauth);
	saveaccesstoken($accesstoken);
	$loggedname = getloggedname($accesstoken);
	$nosession = (!isset($_SESSION['loggedname']));
	saveloggedname($loggedname);
	if ($nosession) {
		$_SESSION['page'] = 1;
	}
	$validsession = (isnum($_SESSION['page']));
	if ($validsession) {
		require_once('friendnames.php');
		$_SESSION['page']++;
	}
}

function gobackordie() {
	if(isvalid()){ 
		if(iscorrect()){ 
			gettweets();
		} else {
			die('Incorrect value.');
		}
	} else {
		die('Invalid value.');
	}
}

gobackordie();

?>
