<?php
	/* EXEMPLE UTILISATION CLASSE SECURITE
	$pseudo = Securite::bdd($_POST['pseudo']);
	$password = Securite::bdd( $_POST['password'] );

	$requete = "SELECT * FROM membre
	WHERE pseudo = '$pseudo' AND password = '$password' ";
	*/
	class Securite
	{
		// DonnŽes entrantes
		public static function bdd($string)
		{
			// On regarde si le type de string est un nombre entier (int)
			if(ctype_digit($string))
			{
				$string = intval($string);
			}
			// Pour tous les autres types
			else
			{
				$string = mysql_real_escape_string($string);
				$string = addcslashes($string, '%_');
			}
				
			return $string;

		}
		// DonnŽes sortantes
		public static function html($string)
		{
			return htmlentities($string);
		}
	}

function test_aj_user ($user_id,$me,$token){
	// VERIF EXISTENCE USER DS BDD
	$query = ('SELECT count( * ) AS coco FROM fb_automate_user WHERE uid ='.$user_id.'');
	$res = mysql_query($query) or die(mysql_error());
	
	while ($row = mysql_fetch_array($res)){
		if ($row['coco'] > 0){
			echo 'existe ! nb :'.$row['coco'];
			
		}else {
			echo 'existe PAS ! nb : '.$row['coco'].'<br/>';
			// INSERTION NEW CLIENT
			$query = "INSERT INTO fb_automate_user SET uid = '".$user_id."', lastname='".mysql_real_escape_string($me['last_name'])."', firstname='".mysql_real_escape_string($me['first_name'])."', token_access = '".mysql_real_escape_string($token)."', created_at = NOW(), last_login=NOW() ON DUPLICATE KEY UPDATE last_login = NOW()";
			$res = mysql_query($query) or die(mysql_error());
		}
	}
}


function post_photo ($facebook){
try {
		//POST PHOTO
		  $photo = './2.jpg'; // Path to the photo on the local filesystem
  $message = 'Photo upload via the PHP SDK!';
		$ret_obj = $facebook->api('/me/photos', 'POST', array(
                                         'source' => '@' . $photo,
                                         'message' => $message,
                                         )
                                      );
        echo '<pre>Photo ID: ' . $ret_obj['id'] . '</pre>';
        
      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl( array(
                       'scope' => 'publish_stream'
                       )); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }  

}

function post_tweeter ($message){


}



?>