<?php
require 'facebook.php';
require '../config/index.php';

// on crée notre objet Facebook
$facebook = new Facebook(array(
      'appId'  => FB_APP_ID,
      'secret' => FB_SECRET,
      'cookie' => true,
      'fileUpload' => true,
));
$chemin_absolu_img = 'http://www.obysky.com/dev/timetopostit/facebook_automate2/img/';
// ON VERIF QU UN POST DOIT ETRE POSTEE COUNT NON POSTE ET INTERVALE 1 JOUR AVANT
	$query = ('SELECT count( * ) AS coco FROM fb_automate_post WHERE posted_for <= NOW() and posted_for >= NOW() - INTERVAL 1 DAY and posted_post = 0');
	$res = mysql_query($query) or die(mysql_error());
	
	while ($row = mysql_fetch_array($res)){
		if ($row['coco'] > 0){
			echo 'Post(s) a faire ! nb :'.$row['coco'].'<br/>';
			
			echo ' premier : token : '.$facebook->getAccessToken().'<br/>';


			// TRAITEMENT DES POST A EFFECTUER
				$query2 = ('SELECT * FROM fb_automate_user,fb_automate_post WHERE fb_automate_post.uid = fb_automate_user.uid and posted_for <= NOW() and posted_for >= NOW() - INTERVAL 1 DAY and posted_post = 0');
				$res2 = mysql_query($query2) or die(mysql_error());

				while ($row2 = mysql_fetch_array($res2)){
				
					echo ' second : token : '.$row2['token_access'].'<br/>';

				
					// RECUP DES DONNEES
					if ($row2['lien_post']!=null){
					$lien = $row2['lien_post'];
					}else {$lien='';}
					//PHOTO IF FILE EXIST
				/*	$filename = '../facebook_automate2/img/'.$row2['id_post'].'.jpg';
					if (file_exists($filename)) {echo 'photo exist !!!<br/>';
						$photo = 'http://www.obysky.com/dev/timetopostit/facebook_automate2/img/'.$row2['id_post'].'.jpg';
					} else {echo 'pas de photo !!!<br/>';
						$photo='';
					}*/
					
//LISTAGE FICHIERS PHOTOS
$dirname = '../facebook_automate2/img/';
$dir = opendir($dirname);
$count_photos=0;
while($file = readdir($dir)) {
if($file != '.' && $file != '..' && !is_dir($dirname.$file))
{

	if (preg_match("#^".$row2['id_post']."_#", $file))
    {
    $count_photos++;
	echo 'nbr photo concerne : '.$count_photos.'<br/>';

		echo '<img src="'.$dirname.$file.'" width="100px">';
		

		try
		{
				$facebook->setAccessToken($row2['token_access']);
				echo ' troisieme : token : '.$facebook->getAccessToken().'<br/>';

					
			// SI CAS PHOTOS ALBUM
			if ($row2['type_post']=='album'){
				// SI PAGE ALORS ACCES TOKEN DE LA PAGE
			/*	if ($row2['type_page']!='profil'){
					$page_id = $row2['type_page'];
					$page_info = $facebook->api("/$page_id?fields=access_token");
					$facebook->setAccessToken($page_info['access_token']);
				}*/
				
			
				if ($row2['type_page']=='profil'){
////////////////////////////////////////////
					 $facebook->setFileUploadSupport(true);
					 
					 //Upload a photo to album of ID...
					$photo_details = array(
					'message'=> $row2['message_post']
					);
					$file=$dirname.$file; //Example image file
					$photo_details['image'] = '@' . realpath($file);
  
					$upload_photo = $facebook->api('/'.$row2['uid_album'].'/photos', 'post', $photo_details);
					//UPDATE DE LA BASE
					 $query3 = ('UPDATE fb_automate_post SET posted_post = 1 WHERE id_post = '.$row2['id_post'].'');
						$res3 = mysql_query($query3) or die(mysql_error());
////////////////////////////////////////////
			}else // CAS PAGE
			{
			////////////////////////////////////////////
			

					 $facebook->setFileUploadSupport(true);
					
					 $page_id = $row2['type_page'];
					 $page_info = $facebook->api("/$page_id?fields=access_token");
					 $facebook->setAccessToken($page_info['access_token']);

					 
					 //Upload a photo to album of ID...
					$photo_details = array(
					'message'=> $row2['message_post']
					);
					$file=$dirname.$file; //Example image file
					$photo_details['image'] = '@' . realpath($file);
  
					$upload_photo = $facebook->api('/'.$row2['uid_album'].'/photos', 'post', $photo_details);
					//UPDATE DE LA BASE
					 $query3 = ('UPDATE fb_automate_post SET posted_post = 1 WHERE id_post = '.$row2['id_post'].'');
						$res3 = mysql_query($query3) or die(mysql_error());
////////////////////////////////////////////

			}
			
			
			}// FIN POST ALBUM PHOTO
			else {
					// POST PROFIL PAGE OK
					 if ($row2['type_page']=='profil'){
						$publishStream = $facebook->api("/$currentUser/feed", 'post', array(
					'message' => $row2['message_post'],
					'link'    => $lien,
					'picture' => $chemin_absolu_img.$file,
					'name'    => '',
					'description'=> ''
						));
					 } // FIN POST PROFIL
					 
					 else {
echo 'fan page !!!!!!!!!';
					// PAGE OFICIELLE
	$page_id = $row2['type_page'];
    $page_info = $facebook->api("/$page_id?fields=access_token");
    if( !empty($page_info['access_token']) ) {
        $args = array(
            'access_token'  => $page_info['access_token'],
            'message' => $row2['message_post'],
			'link'    => $lien,
			'picture' => $chemin_absolu_img.$file,
			'name'    => '',
			'description'=> ''
        );
        $post_id = $facebook->api("/$page_id/feed","post",$args);
    }
						}
		//TWEET SI BESOIN
		echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
		echo '<br/>uname : '.$row2['uname'];
		
		if ($row2['uname']!=''){
			
			$query3 = ('SELECT * FROM fb_automate_post,fb_automate_user_tweeter WHERE fb_automate_user_tweeter.uname=fb_automate_post.uname and fb_automate_post.id_post='.$row2['id_post'].'');
			$res3 = mysql_query($query3) or die(mysql_error());
			$row3 = mysql_fetch_array($res3);
			echo 'oauth_token : '.$row3['oauth_token'];
		$msg = $row2['message_post'];
			$twitterObj->setToken($row3['oauth_token'], $row3['oauth_token_secret']);
			
			
			$update_status = $twitterObj->post_statusesUpdate(array('media[]' => $chemin_absolu_img.$file, 'status' => $msg));
			if ($temp = $update_status->response){
				echo "<div align='center'>Updated your Timeline Successfully .</div>";
			}
		}
		//FIN TWEET
		//UPDATE DE LA BASE
					 $query3 = ('UPDATE fb_automate_post SET posted_post = 1 WHERE id_post = '.$row2['id_post'].'');
					$res3 = mysql_query($query3) or die(mysql_error());

		}
		
				
					
		///////////////////////////////
					 // FIN POST PAGE
		} 
		catch (FacebookApiException $e)
		{
					echo 'l 157 !!!';
					print_r($e);
		}
					
					
					
    }
}
}
closedir($dir); 
// SI AUCUNE PHOTO SIMPLE POST
if ($count_photos<=0){
$facebook->setAccessToken($row2['token_access']);
				echo ' du bas 1 : token : '.$row2['token_access'].'<br/>';

				echo ' du bas 2 : token : '.$facebook->getAccessToken().'<br/>';


// POST PROFIL PAGE OK
					 if ($row2['type_page']=='profil'){
						$publishStream = $facebook->api("/$currentUser/feed", 'post', array(
					'message' => $row2['message_post'],
					'link'    => $lien,
					'picture' => $chemin_absolu_img.$file,
					'name'    => '',
					'description'=> ''
						));
					 //UPDATE DE LA BASE
					 $query3 = ('UPDATE fb_automate_post SET posted_post = 1 WHERE id_post = '.$row2['id_post'].'');
						$res3 = mysql_query($query3) or die(mysql_error());
					 } // FIN POST PROFIL
					 
					 else {
echo 'fan page !!!!!!!!!';
					// PAGE OFICIELLE
	$page_id = $row2['type_page'];
    $page_info = $facebook->api("/$page_id?fields=access_token");
    if( !empty($page_info['access_token']) ) {
        $args = array(
        
            'access_token'  => $page_info['access_token'],
            'message' => $row2['message_post'],
			'link'    => $lien,
			'picture' => $chemin_absolu_img.$file,
			'name'    => '',
			'description'=> ''
        );
        $post_id = $facebook->api("/$page_id/feed","post",$args);
    }
					//UPDATE DE LA BASE
					 $query3 = ('UPDATE fb_automate_post SET posted_post = 1 WHERE id_post = '.$row2['id_post'].'');
					$res3 = mysql_query($query3) or die(mysql_error());
					
					}
//TWEET SI BESOIN
		echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
		echo '<br/>uname : '.$row2['uname'];
		
		if ($row2['uname']!=''){
			
			$query3 = ('SELECT * FROM fb_automate_post,fb_automate_user_tweeter WHERE fb_automate_user_tweeter.uname=fb_automate_post.uname and fb_automate_post.id_post='.$row2['id_post'].'');
			$res3 = mysql_query($query3) or die(mysql_error());
			$row3 = mysql_fetch_array($res3);
			echo 'oauth_token : '.$row3['oauth_token'];
		$msg = $row2['message_post'];
			$twitterObj->setToken($row3['oauth_token'], $row3['oauth_token_secret']);
			$update_status = $twitterObj->post_statusesUpdate(array('status' => $msg));
			if ($temp = $update_status->response){
				echo "<div align='center'>Updated your Timeline Successfully .</div>";
			}
		}
		//FIN TWEET

}
//FIN LISTAGE FICHIERS
					
				}// FIN WHILE ROW2
			
			
		}else {
			echo 'Aucun post l 233<br/>';
		}
	}

echo 'token final : '.$facebook->getAccessToken().'<br/>';
echo $currentUser.'<br/>';
if($currentUser)
{
	try
	{
		$facebook_profile = $facebook->api('/me');
    }
	catch (FacebookApiException $e)
	{
		echo 'l 27 !!!';
		print_r($e);
		$user = null;
	}
}

// on récupère les URL de Login & de Logout
//
// les scopes sont les autorisations spéciale, une liste est disponible ici : 
// http://developers.facebook.com/docs/reference/api/permissions/
//
$loginUrl = $facebook->getLoginUrl(array('scope' => 'email,user_about_me,user_likes,friends_likes,publish_actions,status_update,read_friendlists,offline_access,publish_stream,manage_pages,user_photos,friends_photos,photo_upload'));
//$logoutUrl  = $facebook->getLogoutUrl();

