<?php
$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
$oauth_token = $_GET['oauth_token'];
if($oauth_token == '' or (isset($_SESSION['ot']) and isset($_SESSION['ots'])))
{
$url = $twitterObj->getAuthorizationUrl();

	if (isset($_SESSION['ot']) and $_SESSION['ot']!='' and isset($_SESSION['ots']) and $_SESSION['ots']!=''){
		$twitterObj->setToken($_SESSION['ot'], $_SESSION['ots']);
		
		$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;
		$username = $twitterInfo->screen_name;
$_SESSION['username']=$username;
$profilepic = $twitterInfo->profile_image_url;
$_SESSION['profilepic']=$profilepic;
	}

}
else
{
$twitterObj->setToken($oauth_token);
$token = $twitterObj->getAccessToken();
$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
$_SESSION['ot'] = $token->oauth_token;
$_SESSION['ots'] = $token->oauth_token_secret;
$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;

$username = $twitterInfo->screen_name;
$_SESSION['username']=$username;
$profilepic = $twitterInfo->profile_image_url;
$_SESSION['profilepic']=$profilepic;

// ENREGISTEMENT DANS LA BASE DU PROFIL ET CLES ACCES
	// VERIF EXISTENCE USER DS BDD
$query = ('SELECT count( * ) AS coco FROM fb_automate_user_tweeter WHERE uname ="'.$username.'"');
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($res);
		if ($row['coco'] < 1){
			$query = "INSERT INTO fb_automate_user_tweeter SET uname = '".$username."', oauth_token = '".$_SESSION['ot']."', oauth_token_secret = '".$_SESSION['ots']."', created_at = NOW()";
			if ($res = mysql_query($query) or die(mysql_error())){echo 'NEW user inserted';}
		}
// FIN ENREGISTEMENT DANS LA BASE DU PROFIL ET CLES ACCES


}


// SI CONNECTE INCLUS FORMULAIRE ET AFFICHE BONJOUR
if (isset($_SESSION['ot']) and $_SESSION['ot']!='' and isset($_SESSION['ots']) and $_SESSION['ots']!=''){
$profilepic = $_SESSION['profilepic'];
$username = $_SESSION['username'];
echo 'Bonjour : '.$_SESSION['username'].'  <img class=\'fbk_connect_button\' src='.$_SESSION['profilepic'].' />';
}
echo "<span class=\"lien_reconnect\">";
echo "Se re-connecter via Twiiter : <a href='$url'><img class=\"fbk_connect_button\" src=\"sources/logo_twitter_carre.png\"/></a>";
echo "</span>";
?>