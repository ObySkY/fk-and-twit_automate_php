<?php
require '../libs/facebook/facebook.php';
// on crŽe notre objet Facebook
$facebook = new Facebook(array(
      'appId'  => FB_APP_ID,
      'secret' => FB_SECRET,
      'cookie' => true,
      'fileUpload' => true,
));

$facebook_token = $facebook->getAccessToken();

// puis on tente de rŽcuperer l'instance d'un Žventuel utilisateur en cours
if (isset($_SESSION['id_user'])){
	$currentUser = $_SESSION['id_user'];
	
	// DEBUT VERIF SI LE TOKEN EST OK DANS LA BDD SINON ON MET A JOUR
	$query = ('SELECT * FROM fb_automate_user WHERE uid = '.$_SESSION['id_user'].'');
				$res = mysql_query($query) or die(mysql_error());
				$row = mysql_fetch_array($res);
	if ($row['token_access']!=null and $row['token_access']!=$facebook_token){
		
		if ($query = ('UPDATE fb_automate_user SET token_access=\''.$facebook_token.'\' WHERE uid = '.$_SESSION['id_user'])){
				echo 'Confirmation MISE A JOUR Utilisateur Token - Hors Line (Pour les post\'s diférés) ! <br/>';
			}
		$res = mysql_query($query) or die(mysql_error());

	}
	// FIN VERIF SI LE TOKEN EST OK DANS LA BDD SINON ON MET A JOUR

}else {
	$currentUser = $facebook->getUser();
	if ($currentUser!=0){
		$_SESSION['id_user']=$currentUser;
	}
}

if($currentUser)
{
	try
	{
		$facebook_profile = $facebook->api('/me');
    }
	catch (FacebookApiException $e)
	{
    $currentUser = $facebook->getUser();
		echo ' THREADS - FB-CONNECTS ERROR LIGNE l 50 !!!<br/>catch (FacebookApiException $e)<br/>   REBOOT PAGE FAILD - Tentative de reconnexion sur  .... ! <br/> TENTEZ DE REVENIR SUR timetopostit.fr
            <a href="http://www.obysky.com/dev/timetopostit/facebook_automate2/">
            TimeToPost-It  : Tentez encore !
            </a>
        <br/><br/><br/>';
		echo '<h4>Ce service est gratuit, pour toute réclamation : contact@obysky.com<br/> sinon : enjoy : une nouvelle version arrivera bientôt... Bien Mieux ! <br/> Mais rassurez celle-ci est maintenue et fonctionelle jusqu\'à la nouvelle !! EN CAS DE LISTE D ERROR? F5 FERA L AFFAIRE SINON SUPPRIMER LES COOKIES DU DOMAINE / VALABLES 1 ANS - la est l error </h4>';
                echo '<script>
                
                parent.window.location("http://www.obysky.com/dev/timetopostit/facebook_automate2/");
                
                </script>';
                // unset cookies
                        if (isset($_SERVER['HTTP_COOKIE'])) {
                            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                            foreach($cookies as $cookie) {
                                $parts = explode('=', $cookie);
                                $name = trim($parts[0]);
                                setcookie($name, '', time()-1000);
                                setcookie($name, '', time()-1000, '/');
                            }
                        }
		print_r($e);
		$user = null;
	}
// Ajoute a la base si new
test_aj_user ($currentUser,$facebook_profile,$facebook_token,$facebook);
}

// on rŽcupre les URL de Login & de Logout
//
// les scopes sont les autorisations spŽciale, une liste est disponible ici : 
// http://developers.facebook.com/docs/reference/api/permissions/
//
$loginUrl = $facebook->getLoginUrl(array('scope' => 'email,user_about_me,user_likes,friends_likes,publish_actions,status_update,read_friendlists,offline_access,publish_stream,manage_pages,user_photos,friends_photos,photo_upload'));
$logoutUrl  = $facebook->getLogoutUrl();