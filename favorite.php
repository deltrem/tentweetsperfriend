<?php
error_reporting(E_ALL & ~E_NOTICE);
require("lib/twitteroauth.php");
require_once('session.php');
require_once('validate.php');

function isalright2() {
	if (isalphanum($_GET['oauth_verifier']) && isalphanum($_SESSION['oauth_token']) && isalphanum($_SESSION['oauth_token_secret'])) {
		return true;
	} else {
		return false;
	}
}

function isalright1() {
	if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
		return true;
	} else {
		return false;
	}
}

function isalphanum($value) {
	if (preg_match('/^[a-zA-Z0-9]+$/', $value)) {
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

function shortorlong() {
	$twitteroauth = getnewtwitteroauth();
	$accesstoken = getaccesstoken($twitteroauth);
	saveaccesstoken($accesstoken);
	$loggedname = getloggedname($accesstoken);
	saveloggedname($loggedname);
	if ($_POST['do'] == 'create') {
		$tweetsarray = $twitteroauth->get(
			'/favorites/create', 
			array(
				'id' => $_POST['id'];
			)
		);
	} else if ($_POST['do'] == 'destroy') {
		$tweetsarray = $twitteroauth->get(
			'/favorites/destroy', 
			array(
				'id' => $_POST['id'];
			)
		);
	} else {
		die('favorite not created nor destroyed error');
	}
	
	exit();
}

function gobackordie() {
	if(isalright1()){ 
		if(isalright2()){ 
			shortorlong();
		} else {
			die('Incorrect values.');
		}
	} else {
		die('Invalid values');
	}
}

gobackordie();

?>
