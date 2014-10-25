<?php
require_once ('./../../config/index.php');
require_once ('../lib/fonctions.php');


if (isset($_GET['id'])){$_GET['id'] = Securite::html($_GET['id']);}

if (isset($_GET['id']) and $_GET['id']!= null){
	//CAS PROFIL
	echo 'Selection de l album :<br/>';
	if ($_GET['id']=='profil'){
		$query = ('SELECT * FROM fb_automate_user,fb_automate_album WHERE fb_automate_album.uid = fb_automate_user.uid');
		$res = mysql_query($query) or die(mysql_error());

echo '<select id="album" name="album" >';

		while ($row = mysql_fetch_array($res)){
			echo '<option value="'.$row['uid_album'].'">'.$row['name_album'].'</option>';
		}
echo '</select>';
	}// CAS PAGES
	else {
		$query = ('SELECT * FROM fb_automate_page,fb_automate_album WHERE fb_automate_album.uid = fb_automate_page.uid_page');
		$res = mysql_query($query) or die(mysql_error());
echo '<select id="album" name="album" >';

		while ($row = mysql_fetch_array($res)){
			echo '<option value="'.$row['uid_album'].'">'.$row['name_album'].'</option>';
		}
echo '</select>';
		
	}
echo '<br/>';
}

?>