<?php
	/* EXEMPLE UTILISATION CLASSE SECURITE
	$pseudo = Securite::bdd($_POST['pseudo']);
	$password = Securite::bdd( $_POST['password'] );

	$requete = "SELECT * FROM membre
	WHERE pseudo = '$pseudo' AND password = '$password' ";
	*/
	class Securite
	{
		// Données entrantes
		public static function bdd($string)
		{
			// On regarde si le type de string est un nombre entier (int)
			if(ctype_digit($string))
			{
				//$string = intval($string);
			}
			// Pour tous les autres types
			else
			{
				$string = mysql_real_escape_string($string);
				$string = addcslashes($string, '%_');
			}
				
			return $string;

		}
		// Données sortantes
		public static function html($string)
		{
			return htmlentities($string);
		}
	}


function test_aj_user ($user_id,$me,$token,$facebook){
	// VERIF EXISTENCE USER DS BDD
	$query = ('SELECT count( * ) AS coco FROM fb_automate_user WHERE uid ="'.$user_id.'"');
	$res = mysql_query($query) or die(mysql_error());
	
	while ($row = mysql_fetch_array($res)){
		if ($row['coco'] > 0){
			echo '<a href = "http://www.obysky.com/dev/timetopostit/facebook_automate2/index.php?mise_a_jour=ok">Facebook : Voulez vous actualiser vos donnees de pages et albums ? - Ceci peut prendre un certain temps ...</a>';
			mise_a_jour_user($user_id,$me,$token,$facebook);
			
		}else {
			echo 'user existe PAS ! 
			<br/><br/><br/>
			RECHARGER LA PAGE AVEC F5 ou Ctrl + R
			PROBLEME PAS ENCORE REGLE APPLIS SINON OPERATIONELLE F5 ou Ctrl + R
			<br/><br/>F5 ou Ctrl + R
			<br/><br/><br/>
			<br/><br/><br/>
SI TOUJOUR UNE ERREUR // SUPPRIMER TOUT LES COOKIES DU DOMAINE (ACTUELLEMENT VALABLE 1 ANS ! ) ET OP REMISE EN FONXTION / ACTUALISATION DES TOKEN/ ETC / ...) ....
			
			nb : '.$row['coco'].'<br/>';
			// INSERTION NEW CLIENT
			$query = "INSERT INTO fb_automate_user SET uid = '".$user_id."', lastname='".mysql_real_escape_string($me['last_name'])."', firstname='".mysql_real_escape_string($me['first_name'])."', token_access = '".mysql_real_escape_string($token)."', created_at = NOW(), last_login=NOW() ON DUPLICATE KEY UPDATE last_login = NOW()";
			$res = mysql_query($query) or die(mysql_error());
		//FIN INSERT CLIENT
		
		// ALBUMS DU CLIENT
      	$albums = $facebook->api("/$user_id/albums");

foreach($albums['data'] as $album)
{
       if($album['id'])
		{
      //INSERT DES ALBUMS
      $query2 = "INSERT INTO fb_automate_album SET uid_album = '".$album['id']."',name_album = '".mysql_real_escape_string($album['name'])."', date_create_album = '".$album['created_time']."', uid = '".$user_id."'";
			$res2 = mysql_query($query2) or die(mysql_error());
			echo 'coucou<br/>';
		}
}
      	// FIN ALBUM CLIENT
		
		// AJOUT DE SES PAGES
		$accounts = $facebook->api("/$user_id/accounts");
//page where i want to post

foreach($accounts['data'] as $account)
{
   if($account['id'] and $account['category']!='Application')
   {
      $token_page = $account['access_token'];
      //INSERT DES PAGES
      $query = "INSERT INTO fb_automate_page SET uid_page = '".$account['id']."',name_page = '".$account['name']."', token_access_page = '".mysql_real_escape_string($token_page)."', uid = '".$user_id."'";
			$res = mysql_query($query) or die(mysql_error());
      	
      	// ALBUMS DES PAGES
      	$albums = $facebook->api("/".$account['id']."/albums");

foreach($albums['data'] as $album)
{
       if($album['id'])
		{
      //INSERT DES ALBUMS
      $query2 = "INSERT INTO fb_automate_album SET uid_album = '".$album['id']."',name_album = '".mysql_real_escape_string($album['name'])."', date_create_album = '".$album['created_time']."', uid = '".$account['id']."'";
			$res2 = mysql_query($query2) or die(mysql_error());
						echo 'coucou2<br/>';
		}
}
      	// FIN ALBUM PAGES
   }
}
	//FIN AJOUT PAGES
	// SI utilisateur exist pas on a tout traite et on recharge
	$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
echo 'gggggg';
header("Location: $monUrl");
	
		}
	}
}// FIN FCT TEST AJ USER



function mise_a_jour_user ($user_id,$me,$token,$facebook){

$query = ('SELECT * FROM fb_automate_user WHERE fb_automate_user.uid ='.$user_id.'');
	$res = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($res);
		$token = $row['token_access'];
		//	if ($row['token_access']!= $token){
			//	echo $row['token_access'].'<br/>';
			//		$query2 = "UPDATE fb_automate_user SET token_access   = '".$token."' WHERE uid = '".$user_id."'";
			//		$res2 = mysql_query($query2) or die(mysql_error());
			
		//		echo 'Access token update !<br/>';
		//		echo $row['token_access'].'<br/>';

		//	}
		






if (isset($_GET['mise_a_jour'])){$_GET['mise_a_jour'] = Securite::html($_GET['mise_a_jour']);}
if (isset($_GET['mise_a_jour']) and $_GET ['mise_a_jour']=='ok'){
			// VERIF DES ALBUMS CLIENT
// VERIF SI AJOUT ALBUMS
$albums = $facebook->api("/$user_id/albums");
foreach($albums['data'] as $album)
{
$conteur=0;
	if($album['id'])
	{
		$query = ('SELECT * FROM fb_automate_user,fb_automate_album WHERE fb_automate_user.uid=fb_automate_album.uid and fb_automate_album.uid ='.$user_id.'');
		$res = mysql_query($query) or die(mysql_error());
			while ($row = mysql_fetch_array($res)){
				if ($album['id']==$row['uid_album']) {
					$conteur++;
				}
			}
			if ($conteur==0){
				$query2 = "INSERT INTO fb_automate_album SET uid_album = '".$album['id']."',name_album = '".mysql_real_escape_string($album['name'])."', date_create_album = '".$album['created_time']."', uid = '".$user_id."'";
			$res2 = mysql_query($query2) or die(mysql_error());
			echo 'Un album à été ajouté ! <br/>';
			}
	}
}
//VERIF SI SUPPRESION ALBUMS
$query = ('SELECT * FROM fb_automate_user,fb_automate_album WHERE fb_automate_user.uid=fb_automate_album.uid and fb_automate_album.uid ='.$user_id.'');
$res = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($res)){
$conteur=0;
	$albums = $facebook->api("/$user_id/albums");
	foreach($albums['data'] as $album)
	{
		if($album['id'])
		{
			if ($album['id']==$row['uid_album']) {
					$conteur++;
			}
		}
	}
	if ($conteur==0){
		$query2 = "DELETE FROM fb_automate_album WHERE uid_album = '".$row['uid_album']."'";
		$res2 = mysql_query($query2) or die(mysql_error());
		echo 'Un album à été Supprimé ! <br/>';
	}
}		// FIN VERIF ALBUM CLIENT
		
				// AJOUT DE SES PAGES
		$accounts = $facebook->api("/".$user_id."/accounts");
//page where i want to post

foreach($accounts['data'] as $account)
{
$conteur=0;
   if($account['id'] and $account['category']!='Application')
   {
      $token_page = $account['access_token'];
      //INSERT DES PAGES

      $query = ('SELECT * FROM fb_automate_user,fb_automate_page WHERE fb_automate_user.uid=fb_automate_page.uid and fb_automate_page.uid ='.$user_id.'');
		$res = mysql_query($query) or die(mysql_error());
			while ($row = mysql_fetch_array($res)){
				if ($account['id']==$row['uid_page']) {
					$conteur++;
				}
			}
			if ($conteur==0){
				$query = "INSERT INTO fb_automate_page SET uid_page = '".$account['id']."',name_page = '".$account['name']."', token_access_page = '".mysql_real_escape_string($token_page)."', uid = '".$user_id."'";
			$res = mysql_query($query) or die(mysql_error());
			echo 'Une page à été ajouté ! <br/>';
			}

      	// ALBUMS DES PAGES
      	$albums = $facebook->api("/".$account['id']."/albums");

foreach($albums['data'] as $album)
{
$conteur2=0;
	if($album['id'])
	{
		$query = ('SELECT * FROM fb_automate_page,fb_automate_album WHERE fb_automate_page.uid_page=fb_automate_album.uid and fb_automate_album.uid ='.$account['id'].'');
		$res = mysql_query($query) or die(mysql_error());
			while ($row = mysql_fetch_array($res)){
				if ($album['id']==$row['uid_album']) {
					$conteur2++;
				}
			}
			if ($conteur2==0){
				$query2 = "INSERT INTO fb_automate_album SET uid_album = '".$album['id']."',name_album = '".mysql_real_escape_string($album['name'])."', date_create_album = '".$album['created_time']."', uid = '".$account['id']."'";
			$res2 = mysql_query($query2) or die(mysql_error());
			echo 'Un album de page à été ajouté ! <br/>';
			}
	}
}
      	// FIN ALBUM PAGES
   }
}
	//FIN AJOUT PAGES
// VERIF SUPPRESSION PAGES
		
$query = ('SELECT * FROM fb_automate_user,fb_automate_page WHERE fb_automate_user.uid=fb_automate_page.uid and fb_automate_page.uid ='.$user_id.'');
$res = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_array($res)){
	$conteur=0;
		$accounts = $facebook->api("/$user_id/accounts");
		foreach($accounts['data'] as $account){
			if($account['id'] and $account['category']!='Application')
			{
				$token_page = $account['access_token'];
				if ($account['id']==$row['uid_page']) {
					$conteur++;
				}
				
			}
		
		
		
		// VERIF SUPPR ALBUMS PAGES
$query2 = ('SELECT * FROM fb_automate_page,fb_automate_album WHERE fb_automate_page.uid_page=fb_automate_album.uid and fb_automate_album.uid ='.$account['id'].'');
$res2 = mysql_query($query2) or die(mysql_error());
	while ($row2 = mysql_fetch_array($res2)){
	$conteur2=0;
	$albums = $facebook->api("/".$account['id']."/albums");

		foreach($albums['data'] as $album)
		{
			if($album['id'])
			{
				if ($album['id']==$row2['uid_album']) {
					$conteur2++;
				}
			}
		}
		if ($conteur2==0){
				$query3 = "DELETE FROM fb_automate_album WHERE uid_album = '".$row2['uid_album']."'";
			$res3 = mysql_query($query3) or die(mysql_error());
			echo 'Un album de page à été supprimé ! <br/>';
		}
		
		
	}// FIN VERIF SUPPR ALBUM DE PAGE
		
		
		}
		if ($conteur==0){
			$query2 = "DELETE FROM fb_automate_page WHERE uid_page = '".$row['uid_page']."'";
			$res2 = mysql_query($query2) or die(mysql_error());
			echo 'Une page à été Supprimé ! <br/>';
		}
	
	
	}

		
		
// FIN VERIF SUPPRESSION PAGES
		


}
}// FIN MISE A JOUR USER





// INSERT PHOTO
function photo_insert ($photo,$dossier_dest)
{
$compteur=0;
$UID=mysql_insert_id();
$taille_tab = count($_FILES[$photo]['name']);

if (isset($_FILES[$photo])){
foreach ($_FILES[$photo]['name'] as $i => $name) {
		//Vérif fichier envoyé sans erreur
		if ($_FILES[$photo]['error'][$i] == 0)
		{
			//inserer une fonction pour réduire la photo si besoin !!!
		
		//Controle de la taille du fichier
			if ($_FILES[$photo]['size'][$i] <= 10000000)
			{ 
				//Vérif de l'extension
				$infosfichier = pathinfo($_FILES[$photo]['name'][$i]);
				$extension_upload = $infosfichier['extension'];
				$extensions_autorisees = array('JPEG','JPG','jpg','jpeg');
				if (in_array($extension_upload, $extensions_autorisees))
					{ 
						$source = imagecreatefromjpeg($_FILES[$photo]['tmp_name'][$i]);
						$TailleImageChoisie = getimagesize($_FILES[$photo]['tmp_name'][$i]);
						$NouvelleLargeur = 650; //Largeur choisie à 350 px mais modifiable
						$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
						$destination = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur");
						imagecopyresampled($destination , $source  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
						// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
						imagejpeg($destination, ''.$dossier_dest.'/' . $UID.'_'.$i.'.jpg');
						// Validation du fichier et le stocker définitivement
						echo 'L\'envoi de la photo < '.$i.' > a bien ete effectue !<br>';
						$compteur++;
					} else {echo 'Mauvais format de fichier : JPEG,JPG,jpeg,jpg autorise<br/>';}
			}
		}
		
		
}
if ($compteur >0){
return true;
}
// FIN FOREACH

}// FIN ISSET FILE
}
?>
