<?php
session_start();
?>
<?php 
require_once ('../lib/facebook.php');
require_once ('../lib/config.php');
require_once ('../lib/fonctions.php');
$facebook = new Facebook(array(
        'appId'     =>  "331422990223833",
        'secret'    => "ee4f4d09a85c2c69088bda885c8accd1",
        ));

if (isset($_SESSION['id_user'])){
	$currentUser = $_SESSION['id_user'];
	// REKET POUR TOKEN
	$query = ('SELECT * FROM fb_automate_user WHERE uid = '.$_SESSION['id_user'].'');
				$res = mysql_query($query) or die(mysql_error());
				$row = mysql_fetch_array($res);
	$facebook->setAccessToken($row['token_access']);
}	
// DEBUT TEST CONTROLE LIKE
    $likes = $facebook->api("/me/likes");

	foreach($likes['data'] as $user_friend){
			//print_r ($user_friend);
		if ($user_friend['id']=="345064018946390"){
			echo 'ok';
			//break;
		}
	}

  //FIN TEST CONTROLE LIKE		
?>